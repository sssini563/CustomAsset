<?php
/**
 * Deep Debug LDAP Test
 * Usage: php scripts/debug-ldap-test.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use App\Models\Ldap;

echo "=== Deep Debug LDAP Test ===\n\n";

$settings = Setting::first();

echo "Current Settings:\n";
echo "  ldap_enabled: " . ($settings->ldap_enabled ?? 'NULL') . "\n";
echo "  ldap_server: " . ($settings->ldap_server ?? 'NULL') . "\n";
echo "  ldap_port: " . ($settings->ldap_port ?? 'NULL') . "\n";
echo "  ldap_basedn: " . ($settings->ldap_basedn ?? 'NULL') . "\n";
echo "  ldap_filter (raw): " . ($settings->ldap_filter ?? 'NULL') . "\n";
echo "  ldap_username_field: " . ($settings->ldap_username_field ?? 'NULL') . "\n";
echo "  ldap_uname: " . ($settings->ldap_uname ?? 'NULL') . "\n";
echo "\n";

// Test filter replacement
$originalFilter = $settings->ldap_filter;
$testFilter = str_replace('%s', '*', $originalFilter);

echo "Filter Transformation:\n";
echo "  Original: {$originalFilter}\n";
echo "  Replaced: {$testFilter}\n";

// Simulate what Snipe-IT does
if ($testFilter != '' && substr($testFilter, 0, 1) != '(') {
    $finalFilter = "($testFilter)";
} else {
    $finalFilter = $testFilter;
}
echo "  Final (with parens): {$finalFilter}\n\n";

// Try to connect
try {
    echo "Step 1: Connecting to LDAP...\n";
    $connection = Ldap::connectToLdap();
    echo "  ✅ Connected\n\n";
    
    echo "Step 2: Binding with admin credentials...\n";
    Ldap::bindAdminToLdap($connection);
    echo "  ✅ Bound\n\n";
    
    echo "Step 3: Searching for users...\n";
    echo "  Base DN: {$settings->ldap_basedn}\n";
    echo "  Filter: {$finalFilter}\n";
    
    // Get attributes that we need
    $attributes = [
        $settings->ldap_username_field ?? 'samaccountname',
        $settings->ldap_fname_field ?? 'givenname',
        $settings->ldap_lname_field ?? 'sn',
        $settings->ldap_email ?? 'mail',
    ];
    $attributes = array_filter($attributes);
    
    echo "  Attributes: " . implode(', ', $attributes) . "\n\n";
    
    // Try manual search first
    echo "Manual LDAP Search Test:\n";
    $search = @ldap_search($connection, $settings->ldap_basedn, $finalFilter, $attributes, 0, 10);
    
    if (!$search) {
        echo "  ❌ ldap_search failed: " . ldap_error($connection) . "\n";
        echo "  Error code: " . ldap_errno($connection) . "\n\n";
        
        // Try with simpler filter
        echo "Trying simpler filter: (objectClass=user)\n";
        $search = @ldap_search($connection, $settings->ldap_basedn, '(objectClass=user)', $attributes, 0, 10);
        
        if (!$search) {
            echo "  ❌ Still failed: " . ldap_error($connection) . "\n\n";
        } else {
            $entries = ldap_get_entries($connection, $search);
            echo "  ✅ Simple filter works! Found {$entries['count']} users\n\n";
            echo "This means your Base DN and connection are OK,\n";
            echo "but the filter '{$finalFilter}' is not working.\n\n";
        }
    } else {
        $entries = ldap_get_entries($connection, $search);
        echo "  ✅ Search successful! Found {$entries['count']} users\n\n";
        
        if ($entries['count'] > 0) {
            echo "Sample users:\n";
            for ($i = 0; $i < min(3, $entries['count']); $i++) {
                $user = $entries[$i];
                echo "  User " . ($i+1) . ":\n";
                
                foreach ($attributes as $attr) {
                    $attrLower = strtolower($attr);
                    $value = $user[$attrLower][0] ?? 'N/A';
                    echo "    {$attr}: {$value}\n";
                }
                echo "\n";
            }
        }
    }
    
    // Now test using Snipe-IT's method
    echo str_repeat("-", 70) . "\n\n";
    echo "Testing with Snipe-IT's findLdapUsers() method:\n";
    
    try {
        $results = Ldap::findLdapUsers(null, 10, $testFilter);
        
        if (isset($results['count'])) {
            echo "  ✅ Found {$results['count']} users\n";
            
            if ($results['count'] > 0) {
                echo "\nFirst user data:\n";
                $firstUser = $results[0];
                foreach ($firstUser as $key => $value) {
                    if (!is_numeric($key) && $key !== 'count') {
                        echo "  {$key}: ";
                        if (is_array($value)) {
                            echo $value[0] ?? '(empty array)';
                        } else {
                            echo $value;
                        }
                        echo "\n";
                    }
                }
            }
        } else {
            echo "  ⚠️  No count field in results\n";
            var_dump($results);
        }
    } catch (\Exception $e) {
        echo "  ❌ Exception: " . $e->getMessage() . "\n";
        echo "  Trace: " . $e->getTraceAsString() . "\n";
    }
    
    ldap_close($connection);
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "RECOMMENDATIONS:\n\n";

if (empty($settings->ldap_filter)) {
    echo "❌ ldap_filter is empty! Set it to: sAMAccountName=%s\n";
} elseif (strpos($settings->ldap_filter, '%s') === false) {
    echo "⚠️  ldap_filter doesn't contain %s: {$settings->ldap_filter}\n";
    echo "   This will work for sync but not for login.\n";
} else {
    echo "✅ ldap_filter format looks OK: {$settings->ldap_filter}\n";
}

if (empty($settings->ldap_basedn)) {
    echo "❌ ldap_basedn is empty!\n";
} else {
    echo "✅ ldap_basedn is set: {$settings->ldap_basedn}\n";
}

if (empty($settings->ldap_username_field)) {
    echo "❌ ldap_username_field is empty! Set it to: samaccountname\n";
} else {
    echo "✅ ldap_username_field is set: {$settings->ldap_username_field}\n";
}

echo "\n";
