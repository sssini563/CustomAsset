<?php

/**
 * LDAP Login Test Script
 * 
 * Usage: php test-ldap-login.php username password
 * Example: php test-ldap-login.php hery.sunu MyPassword123
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use App\Models\Ldap;
use Illuminate\Support\Facades\Log;

// Get username and password from command line arguments
$username = $argv[1] ?? null;
$password = $argv[2] ?? null;

if (!$username || !$password) {
    echo "Usage: php test-ldap-login.php <username> <password>\n";
    echo "Example: php test-ldap-login.php hery.sunu MyPassword123\n";
    exit(1);
}

echo "=================================================\n";
echo "LDAP LOGIN TEST\n";
echo "=================================================\n\n";

// Get LDAP settings
$settings = Setting::getSettings();

echo "LDAP Configuration:\n";
echo "-------------------\n";
echo "LDAP Enabled: " . ($settings->ldap_enabled ? 'YES' : 'NO') . "\n";
echo "LDAP Server: " . $settings->ldap_server . "\n";
echo "LDAP Port: " . $settings->ldap_port . "\n";
echo "LDAP Base DN: " . $settings->ldap_basedn . "\n";
echo "LDAP Username Field: " . $settings->ldap_username_field . "\n";
echo "LDAP Filter: " . $settings->ldap_filter . "\n";
echo "LDAP Auth Filter Query: " . $settings->ldap_auth_filter_query . "\n";
echo "LDAP Version: " . $settings->ldap_version . "\n";
echo "LDAP TLS: " . ($settings->ldap_tls ? 'YES' : 'NO') . "\n";
echo "Is AD: " . ($settings->is_ad ? 'YES' : 'NO') . "\n";
echo "AD Domain: " . $settings->ad_domain . "\n";
echo "\n";

if (!$settings->ldap_enabled) {
    echo "ERROR: LDAP is not enabled in settings!\n";
    exit(1);
}

echo "Testing LDAP Authentication:\n";
echo "----------------------------\n";
echo "Username: " . $username . "\n";
echo "Password: " . str_repeat('*', strlen($password)) . "\n\n";

try {
    echo "Step 1: Attempting to bind user to LDAP...\n";
    
    $ldap_user = Ldap::findAndBindUserLdap($username, $password);
    
    if (!$ldap_user) {
        echo "FAILED: Could not find or bind user in LDAP\n";
        echo "This could mean:\n";
        echo "  - Username or password is incorrect\n";
        echo "  - User doesn't exist in LDAP directory\n";
        echo "  - LDAP server is unreachable\n";
        echo "  - LDAP filter is incorrect\n";
        exit(1);
    }
    
    echo "SUCCESS: User found and bound to LDAP!\n\n";
    
    echo "Step 2: Parsing LDAP user attributes...\n";
    $ldap_attr = Ldap::parseAndMapLdapAttributes($ldap_user);
    
    echo "LDAP Attributes Retrieved:\n";
    echo "  - Email: " . ($ldap_attr['email'] ?? 'N/A') . "\n";
    echo "  - First Name: " . ($ldap_attr['firstname'] ?? 'N/A') . "\n";
    echo "  - Last Name: " . ($ldap_attr['lastname'] ?? 'N/A') . "\n";
    echo "  - Employee Number: " . ($ldap_attr['employee_num'] ?? 'N/A') . "\n";
    echo "  - Location: " . ($ldap_attr['location_id'] ?? 'N/A') . "\n";
    echo "\n";
    
    echo "Step 3: Checking if user exists in local database...\n";
    $user = \App\Models\User::where('username', '=', $username)
        ->whereNull('deleted_at')
        ->where('ldap_import', '=', 1)
        ->where('activated', '=', '1')
        ->first();
    
    if ($user) {
        echo "SUCCESS: User exists in database (ID: {$user->id})\n";
        echo "  - Username: {$user->username}\n";
        echo "  - Email: {$user->email}\n";
        echo "  - Full Name: {$user->first_name} {$user->last_name}\n";
        echo "  - LDAP Import: " . ($user->ldap_import ? 'YES' : 'NO') . "\n";
        echo "  - Activated: " . ($user->activated ? 'YES' : 'NO') . "\n";
        echo "  - Last Login: " . ($user->last_login ?? 'Never') . "\n";
    } else {
        echo "INFO: User does not exist in database yet\n";
        echo "User will be created on first login\n";
    }
    
    echo "\n=================================================\n";
    echo "LDAP LOGIN TEST: SUCCESS ✓\n";
    echo "=================================================\n";
    echo "\nUser should be able to login via web interface.\n";
    
} catch (\Exception $e) {
    echo "\n=================================================\n";
    echo "LDAP LOGIN TEST: FAILED ✗\n";
    echo "=================================================\n";
    echo "\nError Message:\n";
    echo $e->getMessage() . "\n\n";
    echo "Stack Trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
