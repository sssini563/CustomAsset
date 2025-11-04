<?php
/**
 * Create LDAP Users from Directory
 * Usage: php scripts/create-ldap-users.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Setting;
use App\Models\Ldap;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

echo "=== Create LDAP Users ===\n\n";

$settings = Setting::first();

if (!$settings->ldap_enabled) {
    echo "❌ LDAP is not enabled\n";
    exit(1);
}

echo "Fetching users from LDAP...\n";

try {
    $ldapconn = Ldap::connectToLdap();
    Ldap::bindAdminToLdap($ldapconn);
    
    // Get LDAP users
    $ldapUsers = Ldap::findLdapUsers(null, 50); // Get first 50 users
    
    $created = 0;
    $skipped = 0;
    $errors = 0;
    
    echo "Found {$ldapUsers['count']} users in LDAP\n\n";
    
    foreach ($ldapUsers as $key => $ldapUser) {
        if (!is_int($key)) continue; // Skip metadata
        
        $username = $ldapUser[$settings->ldap_username_field][0] ?? null;
        
        if (!$username) {
            $skipped++;
            continue;
        }
        
        // Skip built-in AD accounts
        $skipPatterns = [
            'Administrator', 'Guest', 'krbtgt', 'Operators', 
            'Domain Admins', 'Schema Admins', 'Enterprise Admins'
        ];
        
        $shouldSkip = false;
        foreach ($skipPatterns as $pattern) {
            if (stripos($username, $pattern) !== false) {
                $shouldSkip = true;
                break;
            }
        }
        
        if ($shouldSkip) {
            echo "  ⏭️  Skipping system account: {$username}\n";
            $skipped++;
            continue;
        }
        
        // Check if user already exists
        $existingUser = User::where('username', $username)->first();
        
        if ($existingUser) {
            echo "  ⚠️  User exists: {$username}\n";
            $skipped++;
            continue;
        }
        
        // Get user details
        $firstName = $ldapUser[$settings->ldap_fname_field][0] ?? '';
        $lastName = $ldapUser[$settings->ldap_lname_field][0] ?? '';
        $email = $ldapUser[$settings->ldap_email][0] ?? null;
        $employeeNum = $ldapUser[$settings->ldap_emp_num][0] ?? null;
        
        // Validate email
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "  ❌ Invalid email for {$username}: " . ($email ?: 'none') . "\n";
            $errors++;
            continue;
        }
        
        try {
            // Create user
            $user = new User();
            $user->username = $username;
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $user->employee_num = $employeeNum;
            $user->password = Hash::make(Str::random(40)); // Random password, will use LDAP auth
            $user->activated = 1;
            $user->ldap_import = 1;
            $user->notes = 'Auto-created from LDAP sync';
            
            if ($user->save()) {
                echo "  ✅ Created: {$username} ({$firstName} {$lastName})\n";
                $created++;
            } else {
                echo "  ❌ Failed to save: {$username}\n";
                $errors++;
            }
            
        } catch (\Exception $e) {
            echo "  ❌ Error creating {$username}: " . $e->getMessage() . "\n";
            $errors++;
        }
    }
    
    echo "\n" . str_repeat("=", 70) . "\n";
    echo "SUMMARY:\n";
    echo "  ✅ Created: {$created} users\n";
    echo "  ⏭️  Skipped: {$skipped} users (already exist or system accounts)\n";
    echo "  ❌ Errors: {$errors} users\n";
    echo "\n";
    
    if ($created > 0) {
        echo "Users created successfully!\n";
        echo "They can now login with their LDAP credentials.\n";
    }
    
    ldap_close($ldapconn);
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
