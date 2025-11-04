<?php
/**
 * Detailed LDAP Sync with Debugging
 * Usage: php scripts/ldap-sync-debug.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Setting;
use App\Models\Ldap;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

echo "=== Detailed LDAP Sync Debug ===\n\n";

$settings = Setting::first();

if (!$settings->ldap_enabled) {
    echo "❌ LDAP is not enabled\n";
    exit(1);
}

echo "LDAP Settings:\n";
echo "  Server: {$settings->ldap_server}\n";
echo "  Base DN: {$settings->ldap_basedn}\n";
echo "  Filter: {$settings->ldap_filter}\n";
echo "  Username Field: {$settings->ldap_username_field}\n";
echo "  Email Field: {$settings->ldap_email}\n";
echo "  First Name Field: {$settings->ldap_fname_field}\n";
echo "  Last Name Field: {$settings->ldap_lname_field}\n\n";

// Connect to LDAP
try {
    echo "Connecting to LDAP...\n";
    $ldapconn = Ldap::connectToLdap();
    Ldap::bindAdminToLdap($ldapconn);
    echo "✅ Connected and bound\n\n";
} catch (\Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Map LDAP attributes
$ldap_map = [
    "username" => $settings->ldap_username_field,
    "last_name" => $settings->ldap_lname_field,
    "first_name" => $settings->ldap_fname_field,
    "email" => $settings->ldap_email,
    "emp_num" => $settings->ldap_emp_num,
    "dept" => $settings->ldap_dept,
];

echo "Fetching users from LDAP...\n";

$attributes = array_values(array_filter($ldap_map));

try {
    // Replace %s with * for sync
    $syncFilter = str_replace('%s', '*', $settings->ldap_filter);
    
    // Change limit from 10 to -1 for ALL users, or specify a number
    $limit = $argv[1] ?? 50; // Default 50, or pass as argument: php script.php 100
    
    $results = Ldap::findLdapUsers($settings->ldap_basedn, $limit, $syncFilter, $attributes);
    
    echo "Found {$results['count']} users\n\n";
    
    if ($results['count'] == 0) {
        echo "❌ No users found in LDAP!\n";
        echo "Check your Base DN and filter settings.\n";
        exit(1);
    }
    
    $created = 0;
    $updated = 0;
    $errors = 0;
    
    echo "Processing users:\n";
    echo str_repeat("-", 70) . "\n\n";
    
    for ($i = 0; $i < $results['count']; $i++) {
        $ldapUser = $results[$i];
        
        // Extract user data
        $username = $ldapUser[$ldap_map["username"]][0] ?? null;
        $firstName = $ldapUser[$ldap_map["first_name"]][0] ?? '';
        $lastName = $ldapUser[$ldap_map["last_name"]][0] ?? '';
        $email = $ldapUser[$ldap_map["email"]][0] ?? null;
        $employeeNum = $ldapUser[$ldap_map["emp_num"]][0] ?? null;
        $deptName = $ldapUser[$ldap_map["dept"]][0] ?? null;
        
        if (!$username) {
            echo "  ⏭️  Skipping entry {$i}: No username\n";
            continue;
        }
        
        echo "User {$i}: {$username}\n";
        echo "  Name: {$firstName} {$lastName}\n";
        echo "  Email: " . ($email ?: 'MISSING') . "\n";
        echo "  Employee #: " . ($employeeNum ?: 'N/A') . "\n";
        
        // Check if user exists
        $user = User::where('username', $username)->first();
        
        if ($user) {
            echo "  Status: EXISTS (ID: {$user->id})\n";
            $action = 'updated';
        } else {
            echo "  Status: NEW - Will create\n";
            $user = new User();
            $user->password = Hash::make(\Illuminate\Support\Str::random(40));
            $user->activated = 1;
            $user->locale = 'en-US';
            $action = 'created';
        }
        
        // Validate email
        if (!$email) {
            echo "  ❌ ERROR: Email is required but missing!\n\n";
            $errors++;
            continue;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "  ❌ ERROR: Invalid email format: {$email}\n\n";
            $errors++;
            continue;
        }
        
        // Check for email duplicate (only for new users)
        if (!$user->id) {
            $emailExists = User::where('email', $email)->where('username', '!=', $username)->first();
            if ($emailExists) {
                echo "  ❌ ERROR: Email already used by user: {$emailExists->username}\n\n";
                $errors++;
                continue;
            }
        }
        
        // Update user data
        $user->username = $username;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->employee_num = $employeeNum;
        $user->ldap_import = 1;
        
        // Handle department
        if ($deptName) {
            $department = Department::firstOrCreate(['name' => $deptName]);
            $user->department_id = $department->id;
            echo "  Department: {$deptName} (ID: {$department->id})\n";
        }
        
        // Try to save
        if ($user->save()) {
            if ($action === 'created') {
                echo "  ✅ CREATED successfully (ID: {$user->id})\n";
                $created++;
            } else {
                echo "  ✅ UPDATED successfully\n";
                $updated++;
            }
        } else {
            echo "  ❌ FAILED to save:\n";
            foreach ($user->getErrors()->getMessages() as $field => $messages) {
                foreach ($messages as $message) {
                    echo "     - {$field}: {$message}\n";
                }
            }
            $errors++;
        }
        
        echo "\n";
    }
    
    echo str_repeat("=", 70) . "\n";
    echo "SUMMARY:\n";
    echo "  ✅ Created: {$created}\n";
    echo "  🔄 Updated: {$updated}\n";
    echo "  ❌ Errors: {$errors}\n";
    echo "\n";
    
    if ($created > 0) {
        echo "✅ {$created} new users created from LDAP!\n";
    } elseif ($updated > 0) {
        echo "✅ {$updated} existing users updated from LDAP!\n";
    } else {
        echo "⚠️  No users were created or updated.\n";
        if ($errors > 0) {
            echo "Fix the errors above and try again.\n";
        }
    }
    
    ldap_close($ldapconn);
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
