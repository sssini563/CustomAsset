<?php
/**
 * Check LDAP Settings in Database
 * Usage: php scripts/check-ldap-settings.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

echo "=== Current LDAP Settings in Database ===\n\n";

// Get LDAP settings - Snipe-IT uses single row with columns
$settings = Setting::getLdapSettings()->first();

if (!$settings) {
    echo "❌ No settings found in database.\n";
    exit(1);
}

$ldapFields = [
    'ldap_enabled',
    'ldap_server',
    'ldap_port',
    'ldap_tls',
    'ldap_uname',
    'ldap_pword',
    'ldap_basedn',
    'ldap_filter',
    'ldap_username_field',
    'ldap_lname_field',
    'ldap_fname_field',
    'ldap_auth_filter_query',
    'ldap_version',
    'ldap_active_flag',
    'ldap_emp_num',
    'ldap_email',
    'ldap_server_cert_ignore',
    'ldap_pw_sync',
    'ad_domain',
];

echo "LDAP Configuration:\n";
echo str_repeat("-", 70) . "\n\n";

$currentSettings = [];

foreach ($ldapFields as $field) {
    $value = $settings->$field ?? 'NOT SET';
    
    // Don't show password
    if (strpos($field, 'pword') !== false || strpos($field, 'password') !== false) {
        if (!empty($value) && $value !== 'NOT SET') {
            $value = '******** (encrypted)';
        }
    }
    
    $currentSettings[$field] = $settings->$field ?? null;
    
    $marker = ($settings->$field ?? null) ? '✓' : '  ';
    echo "{$marker} {$field}: {$value}\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "CRITICAL SETTINGS ANALYSIS:\n\n";

// Check critical settings
$issues = [];
$sqlFixes = [];

// 1. Check filter format
$filter = $currentSettings['ldap_filter'];
if ($filter) {
    echo "LDAP Filter: {$filter}\n";
    
    // Check for common issues
    if (strpos($filter, '(') === 0 || substr($filter, -1) === ')') {
        $issues[] = "LDAP Filter has parentheses - this causes 'Bad search filter' error";
        echo "  ❌ ERROR: Filter has parentheses\n";
        echo "  Current: {$filter}\n";
        $fixedFilter = trim($filter, '()');
        // Also check for nested parentheses
        $fixedFilter = preg_replace('/^\(&?\(?(.*?)\)?\)$/', '$1', $fixedFilter);
        echo "  Should be: {$fixedFilter}\n";
        $sqlFixes[] = "UPDATE settings SET ldap_filter = '{$fixedFilter}' WHERE id = {$settings->id};";
    }
    
    if (strpos($filter, '%s') === false) {
        $issues[] = "LDAP Filter doesn't contain %s placeholder";
        echo "  ❌ ERROR: Filter missing %s placeholder\n";
        $sqlFixes[] = "UPDATE settings SET ldap_filter = 'sAMAccountName=%s' WHERE id = {$settings->id};";
    }
    
    if (empty($issues)) {
        echo "  ✅ Filter format looks OK\n";
    }
} else {
    $issues[] = "LDAP Filter not set";
    echo "❌ LDAP Filter: NOT SET\n";
    $sqlFixes[] = "UPDATE settings SET ldap_filter = 'sAMAccountName=%s' WHERE id = {$settings->id};";
}
echo "\n";

// 2. Check auth filter query
$authQuery = $currentSettings['ldap_auth_filter_query'];
if ($authQuery) {
    echo "LDAP Auth Filter Query: {$authQuery}\n";
    
    if (strpos($authQuery, '(') !== false || strpos($authQuery, ')') !== false) {
        $issues[] = "Auth Filter Query contains parentheses";
        echo "  ⚠️  WARNING: Auth query has parentheses (may cause issues)\n";
        echo "  Current: {$authQuery}\n";
        $fixedAuth = str_replace(['(', ')'], '', $authQuery);
        echo "  Recommend: {$fixedAuth} (or leave empty)\n";
        $sqlFixes[] = "UPDATE settings SET ldap_auth_filter_query = '' WHERE id = {$settings->id};";
    } else {
        echo "  ✅ Auth filter format OK\n";
    }
} else {
    echo "LDAP Auth Filter Query: (empty)\n";
    echo "  ✅ Empty is OK\n";
}
echo "\n";

// 3. Check base DN
$baseDn = $currentSettings['ldap_basedn'];
if ($baseDn) {
    echo "Base Bind DN: {$baseDn}\n";
    
    if (strpos($baseDn, 'OU=Users,OU=') !== false || strpos($baseDn, 'OU=Factory') !== false || strpos($baseDn, 'OU=Head Office') !== false) {
        $issues[] = "Base DN is too specific (won't find users in other OUs)";
        echo "  ⚠️  WARNING: Base DN is too specific\n";
        echo "  Current: {$baseDn}\n";
        echo "  Recommended: DC=kindairy,DC=com\n";
        $sqlFixes[] = "UPDATE settings SET ldap_basedn = 'DC=kindairy,DC=com' WHERE id = {$settings->id};";
    } else {
        echo "  ✅ Base DN looks good\n";
    }
} else {
    $issues[] = "Base DN not set";
    echo "❌ Base Bind DN: NOT SET\n";
    $sqlFixes[] = "UPDATE settings SET ldap_basedn = 'DC=kindairy,DC=com' WHERE id = {$settings->id};";
}
echo "\n";

// 4. Check username field
$usernameField = $currentSettings['ldap_username_field'];
if ($usernameField) {
    echo "Username Field: {$usernameField}\n";
    
    if (strtolower($usernameField) !== 'samaccountname') {
        $issues[] = "Username field is '{$usernameField}' (should be 'samaccountname' for AD)";
        echo "  ⚠️  WARNING: For Active Directory, use 'samaccountname'\n";
        $sqlFixes[] = "UPDATE settings SET ldap_username_field = 'samaccountname' WHERE id = {$settings->id};";
    } else {
        echo "  ✅ Username field correct\n";
    }
} else {
    $issues[] = "Username field not set";
    echo "❌ Username Field: NOT SET\n";
    $sqlFixes[] = "UPDATE settings SET ldap_username_field = 'samaccountname' WHERE id = {$settings->id};";
}
echo "\n";

echo str_repeat("=", 70) . "\n";

if (count($issues) > 0) {
    echo "⚠️  ISSUES FOUND (" . count($issues) . "):\n\n";
    foreach ($issues as $i => $issue) {
        echo ($i + 1) . ". {$issue}\n";
    }
    
    if (count($sqlFixes) > 0) {
        echo "\n" . str_repeat("=", 70) . "\n";
        echo "SQL FIX COMMANDS:\n\n";
        echo "Copy and run these commands in MySQL/MariaDB:\n\n";
        
        foreach ($sqlFixes as $sql) {
            echo $sql . "\n";
        }
        
        echo "\n-- Or use artisan tinker:\n";
        echo "php artisan tinker\n";
        echo "\$settings = App\\Models\\Setting::first();\n";
        echo "\$settings->ldap_filter = 'sAMAccountName=%s';\n";
        echo "\$settings->ldap_basedn = 'DC=kindairy,DC=com';\n";
        echo "\$settings->ldap_username_field = 'samaccountname';\n";
        echo "\$settings->ldap_auth_filter_query = '';\n";
        echo "\$settings->save();\n";
    }
    
} else {
    echo "✅ All LDAP settings look correct!\n";
    echo "\nIf still getting errors, check:\n";
    echo "1. Network connectivity: ping 10.10.10.101\n";
    echo "2. LDAP port open: telnet 10.10.10.101 389\n";
    echo "3. LDAP credentials are correct\n";
    echo "4. PHP ldap extension enabled: php -m | grep ldap\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "RECOMMENDED SETTINGS FOR ACTIVE DIRECTORY:\n\n";
echo "ldap_server: ldap://10.10.10.101\n";
echo "ldap_port: 389\n";
echo "ldap_basedn: DC=kindairy,DC=com\n";
echo "ldap_filter: sAMAccountName=%s\n";
echo "ldap_username_field: samaccountname\n";
echo "ldap_fname_field: givenname\n";
echo "ldap_lname_field: sn\n";
echo "ldap_email: mail\n";
echo "ldap_active_flag: useraccountcontrol\n";
echo "ldap_auth_filter_query: (empty or 'objectClass=user')\n";

echo "\n";
