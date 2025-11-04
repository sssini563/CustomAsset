#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== LDAP Configuration ===\n\n";

try {
    $settings = \App\Models\Setting::first();
    
    echo "LDAP Enabled: " . ($settings->ldap_enabled ? 'YES ⚠️' : 'NO') . "\n";
    
    if ($settings->ldap_enabled) {
        echo "LDAP Server: " . ($settings->ldap_server ?? 'Not configured') . "\n";
        echo "LDAP Port: " . ($settings->ldap_port ?? '389') . "\n";
        echo "LDAP TLS: " . ($settings->ldap_tls ? 'Enabled' : 'Disabled') . "\n";
        echo "LDAP Timeout: " . ($settings->ldap_timeout ?? 5) . "s\n";
        echo "LDAP Base DN: " . ($settings->ldap_basedn ?? 'Not configured') . "\n";
        
        echo "\n⚠️  WARNING: LDAP is enabled!\n";
        echo "This can cause 5-30 second login delays if:\n";
        echo "  - LDAP server is slow or unreachable\n";
        echo "  - Network latency is high\n";
        echo "  - LDAP credentials are incorrect\n\n";
        
        echo "To disable LDAP:\n";
        echo "  1. Go to Admin → Settings → LDAP → Disable LDAP\n";
        echo "  OR\n";
        echo "  2. Run: php artisan tinker\n";
        echo "     >>> \$s = App\\Models\\Setting::first();\n";
        echo "     >>> \$s->ldap_enabled = 0;\n";
        echo "     >>> \$s->save();\n";
    } else {
        echo "\n✓ LDAP is disabled. Good!\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
