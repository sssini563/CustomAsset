#!/usr/bin/env php
<?php
/**
 * Disable LDAP and clear LDAP settings
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Disabling LDAP ===\n\n";

try {
    $settings = \App\Models\Setting::first();
    
    if (!$settings) {
        echo "✗ No settings found in database.\n";
        exit(1);
    }
    
    // Backup current settings
    echo "Current LDAP Settings:\n";
    echo "  Enabled: " . ($settings->ldap_enabled ? 'Yes' : 'No') . "\n";
    echo "  Server: " . ($settings->ldap_server ?? 'null') . "\n";
    echo "  Base DN: " . ($settings->ldap_basedn ?? 'null') . "\n\n";
    
    // Disable and clear main LDAP settings
    $settings->ldap_enabled = 0;
    $settings->ldap_server = null;
    $settings->ldap_uname = null;
    $settings->ldap_pword = null;
    $settings->ldap_basedn = null;
    $settings->ldap_filter = null;
    $settings->ldap_username_field = null;
    $settings->ldap_lname_field = null;
    $settings->ldap_fname_field = null;
    $settings->ldap_auth_filter_query = null;
    $settings->ldap_version = null;
    $settings->ldap_tls = 0;
    $settings->ldap_pw_sync = 0;
    $settings->ldap_port = null;
    
    $settings->save();
    
    echo "✓ LDAP has been disabled!\n";
    echo "✓ All LDAP settings have been cleared!\n\n";
    
    // Clear cache to apply changes immediately
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "✓ Cache cleared.\n\n";
    
    echo "Login should now be MUCH faster! 🚀\n";
    echo "Test by logging in again.\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
