<?php
/**
 * Check LDAP Settings in Database
 * Usage: php scripts/check-ldap-settings.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Current LDAP Settings in Database ===\n\n";

// Get all LDAP-related settings
$ldapSettings = DB::table('settings')
    ->where('key', 'like', '%ldap%')
    ->orWhere('key', 'like', '%ad_%')
    ->get();

if ($ldapSettings->isEmpty()) {
    echo "❌ No LDAP settings found in database.\n";
    exit(1);
}

echo "Found " . $ldapSettings->count() . " LDAP settings:\n";
echo str_repeat("-", 70) . "\n\n";

$criticalSettings = [
    'ldap_enabled',
    'ldap_server',
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
];

$currentSettings = [];

foreach ($ldapSettings as $setting) {
    $value = $setting->value;
    
    // Don't show password
    if (strpos($setting->key, 'pword') !== false || strpos($setting->key, 'password') !== false) {
        $value = '********';
    }
    
    $currentSettings[$setting->key] = $setting->value;
    
    $marker = in_array($setting->key, $criticalSettings) ? '⭐' : '  ';
    echo "{$marker} {$setting->key}: {$value}\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "CRITICAL SETTINGS ANALYSIS:\n\n";

// Check critical settings
$issues = [];

// 1. Check filter format
if (isset($currentSettings['ldap_filter'])) {
    $filter = $currentSettings['ldap_filter'];
    echo "✓ LDAP Filter: {$filter}\n";
    
    // Check for common issues
    if (strpos($filter, '(') === 0) {
        $issues[] = "LDAP Filter starts with '(' - this may cause 'Bad search filter' error";
        echo "  ⚠️  WARNING: Filter has parentheses at the start\n";
        echo "  Current: {$filter}\n";
        echo "  Should be: " . trim($filter, '()') . "\n";
    }
    
    if (!strpos($filter, '%s')) {
        $issues[] = "LDAP Filter doesn't contain %s placeholder";
        echo "  ⚠️  WARNING: Filter missing %s placeholder\n";
    }
} else {
    $issues[] = "LDAP Filter not set";
    echo "❌ LDAP Filter: NOT SET\n";
}

// 2. Check auth filter query
if (isset($currentSettings['ldap_auth_filter_query'])) {
    $authQuery = $currentSettings['ldap_auth_filter_query'];
    echo "✓ LDAP Auth Filter Query: {$authQuery}\n";
    
    if (strpos($authQuery, '(') !== false) {
        $issues[] = "Auth Filter Query contains parentheses";
        echo "  ⚠️  WARNING: Auth query has parentheses\n";
        echo "  Current: {$authQuery}\n";
        echo "  Should be: " . str_replace(['(', ')'], '', $authQuery) . "\n";
    }
} else {
    echo "✓ LDAP Auth Filter Query: NOT SET (OK)\n";
}

// 3. Check base DN
if (isset($currentSettings['ldap_basedn'])) {
    $baseDn = $currentSettings['ldap_basedn'];
    echo "✓ Base Bind DN: {$baseDn}\n";
    
    if (strpos($baseDn, 'OU=Users') !== false) {
        $issues[] = "Base DN is specific to OU=Users (may miss users in Factory/Head Office)";
        echo "  ⚠️  WARNING: Base DN may be too specific\n";
        echo "  Current: {$baseDn}\n";
        echo "  Recommended: DC=kindairy,DC=com\n";
    }
} else {
    $issues[] = "Base DN not set";
    echo "❌ Base Bind DN: NOT SET\n";
}

// 4. Check username field
if (isset($currentSettings['ldap_username_field'])) {
    $usernameField = $currentSettings['ldap_username_field'];
    echo "✓ Username Field: {$usernameField}\n";
    
    if (strtolower($usernameField) !== 'samaccountname') {
        $issues[] = "Username field is '{$usernameField}' (should be 'samaccountname' for AD)";
        echo "  ⚠️  WARNING: For Active Directory, use 'samaccountname'\n";
    }
} else {
    $issues[] = "Username field not set";
    echo "❌ Username Field: NOT SET\n";
}

echo "\n" . str_repeat("=", 70) . "\n";

if (count($issues) > 0) {
    echo "⚠️  ISSUES FOUND (" . count($issues) . "):\n\n";
    foreach ($issues as $i => $issue) {
        echo ($i + 1) . ". {$issue}\n";
    }
    
    echo "\n" . str_repeat("=", 70) . "\n";
    echo "FIX RECOMMENDATIONS:\n\n";
    
    echo "Run these SQL commands to fix:\n\n";
    
    // Generate fix SQL
    if (isset($currentSettings['ldap_filter'])) {
        $filter = $currentSettings['ldap_filter'];
        if (strpos($filter, '(') === 0) {
            $fixedFilter = 'sAMAccountName=%s';
            echo "-- Fix LDAP Filter\n";
            echo "UPDATE settings SET value = '{$fixedFilter}' WHERE key = 'ldap_filter';\n\n";
        }
    }
    
    if (isset($currentSettings['ldap_basedn']) && strpos($currentSettings['ldap_basedn'], 'OU=Users') !== false) {
        echo "-- Fix Base DN to cover all OUs\n";
        echo "UPDATE settings SET value = 'DC=kindairy,DC=com' WHERE key = 'ldap_basedn';\n\n";
    }
    
    if (isset($currentSettings['ldap_auth_filter_query']) && !empty($currentSettings['ldap_auth_filter_query'])) {
        echo "-- Clear Auth Filter Query (optional)\n";
        echo "UPDATE settings SET value = '' WHERE key = 'ldap_auth_filter_query';\n\n";
    }
    
    echo "-- Or reset to recommended values\n";
    echo "UPDATE settings SET value = 'sAMAccountName=%s' WHERE key = 'ldap_filter';\n";
    echo "UPDATE settings SET value = 'DC=kindairy,DC=com' WHERE key = 'ldap_basedn';\n";
    echo "UPDATE settings SET value = 'samaccountname' WHERE key = 'ldap_username_field';\n";
    echo "UPDATE settings SET value = '' WHERE key = 'ldap_auth_filter_query';\n";
    
} else {
    echo "✅ No critical issues found with LDAP settings!\n";
    echo "\nIf still getting errors, check:\n";
    echo "1. Network connectivity to LDAP server\n";
    echo "2. LDAP credentials are correct\n";
    echo "3. PHP ldap extension is enabled\n";
}

echo "\n";
