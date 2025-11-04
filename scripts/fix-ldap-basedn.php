<?php
/**
 * Fix LDAP Base DN
 * Usage: php scripts/fix-ldap-basedn.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

echo "=== Fix LDAP Base DN ===\n\n";

$settings = Setting::first();

echo "Current Base DN: {$settings->ldap_basedn}\n\n";

if (strpos($settings->ldap_basedn, 'DomainDnsZones') !== false) {
    echo "❌ ERROR: Base DN contains 'DomainDnsZones' - this is wrong!\n";
    echo "This is a DNS zone, not where users are stored.\n\n";
    
    $correctBaseDn = 'DC=KINDAIRY,DC=COM';
    
    echo "Fixing to: {$correctBaseDn}\n";
    
    $settings->ldap_basedn = $correctBaseDn;
    $settings->save();
    
    echo "✅ Base DN updated successfully!\n\n";
    
    echo "New settings:\n";
    echo "  ldap_basedn: {$settings->ldap_basedn}\n";
    echo "  ldap_filter: {$settings->ldap_filter}\n";
    echo "  ldap_username_field: {$settings->ldap_username_field}\n";
    
} else {
    echo "✅ Base DN looks OK: {$settings->ldap_basedn}\n";
}

echo "\nNow test LDAP again in the web UI!\n";
