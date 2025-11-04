<?php
/**
 * Test LDAP Sync (simulate Test LDAP Synchronization button)
 * Usage: php scripts/test-ldap-sync.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use App\Models\Ldap;
use Illuminate\Support\Facades\Log;

echo "=== Test LDAP Synchronization ===\n\n";

$settings = Setting::first();

if (!$settings || !$settings->ldap_enabled) {
    echo "❌ LDAP is not enabled\n";
    exit(1);
}

echo "LDAP Settings:\n";
echo "  Server: {$settings->ldap_server}\n";
echo "  Base DN: {$settings->ldap_basedn}\n";
echo "  Filter (raw): {$settings->ldap_filter}\n";
echo "  Username Field: {$settings->ldap_username_field}\n\n";

echo "Connecting to LDAP...\n";

try {
    $ldapconn = Ldap::connectToLdap();
    echo "✅ Connected successfully\n\n";
    
    echo "Binding with admin credentials...\n";
    Ldap::bindAdminToLdap($ldapconn);
    echo "✅ Bind successful\n\n";
    
} catch (\Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test different filter variations
$testFilters = [
    'Original filter' => $settings->ldap_filter,
    'Filter with wildcard (correct)' => str_replace('%s', '*', $settings->ldap_filter),
    'OpenLDAP style' => '(objectClass=user)',
    'AD all users' => '(&(objectClass=user)(objectCategory=person))',
];

echo "Testing different filter formats:\n";
echo str_repeat("-", 70) . "\n\n";

foreach ($testFilters as $desc => $testFilter) {
    echo "{$desc}: {$testFilter}\n";
    
    // Add parentheses if not present (like Snipe-IT does)
    if ($testFilter != '' && substr($testFilter, 0, 1) != '(') {
        $finalFilter = "($testFilter)";
    } else {
        $finalFilter = $testFilter;
    }
    
    echo "  Final filter: {$finalFilter}\n";
    
    $attributes = [
        $settings->ldap_username_field,
        $settings->ldap_fname_field,
        $settings->ldap_lname_field,
        $settings->ldap_email,
    ];
    
    $search = @ldap_search($ldapconn, $settings->ldap_basedn, $finalFilter, array_filter($attributes), 0, 5);
    
    if ($search) {
        $entries = ldap_get_entries($ldapconn, $search);
        $count = $entries['count'];
        
        if ($count > 0) {
            echo "  ✅ SUCCESS - Found {$count} user(s)\n";
            
            for ($i = 0; $i < min(3, $count); $i++) {
                $username = $entries[$i][strtolower($settings->ldap_username_field)][0] ?? 'N/A';
                $fname = $entries[$i][strtolower($settings->ldap_fname_field)][0] ?? '';
                $lname = $entries[$i][strtolower($settings->ldap_lname_field)][0] ?? '';
                $email = $entries[$i][strtolower($settings->ldap_email)][0] ?? '';
                
                echo "    - {$username}: {$fname} {$lname} ({$email})\n";
            }
        } else {
            echo "  ⚠️  Filter valid but no users found\n";
        }
    } else {
        $error = ldap_error($ldapconn);
        echo "  ❌ FAILED: {$error}\n";
    }
    echo "\n";
}

echo str_repeat("=", 70) . "\n";
echo "DIAGNOSIS:\n\n";

$originalFilter = $settings->ldap_filter;

if (strpos($originalFilter, '%s') !== false) {
    echo "⚠️  Your filter contains %s placeholder: {$originalFilter}\n";
    echo "\nThe %s placeholder is for LOGIN authentication, not for LDAP sync!\n";
    echo "When testing LDAP sync, Snipe-IT should replace %s with * (wildcard)\n";
    echo "but it seems this is not happening.\n\n";
    
    echo "SOLUTION:\n";
    echo "The filter format is correct for LOGIN, but for LDAP SYNC test,\n";
    echo "Snipe-IT should be using a wildcard query.\n\n";
    
    $fixedFilter = str_replace('%s', '*', $originalFilter);
    echo "Recommended filter for sync: {$fixedFilter}\n";
    echo "This will become: ({$fixedFilter}) after Snipe-IT adds parentheses\n\n";
    
    echo "To fix, you have 2 options:\n\n";
    echo "Option 1: Use artisan command for actual sync (not web test):\n";
    echo "  docker exec snipeit-app-1 php artisan snipeit:ldap-sync --summary\n\n";
    
    echo "Option 2: Temporarily change filter for testing:\n";
    echo "  Change ldap_filter from '{$originalFilter}' to '" . str_replace('%s', '*', $originalFilter) . "'\n";
    echo "  Do the test, then change it back\n";
}

ldap_close($ldapconn);
echo "\n✅ Test complete\n";
