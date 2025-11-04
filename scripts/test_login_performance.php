#!/usr/bin/env php
<?php
/**
 * Test Login Performance - Simulates key operations during login
 * Usage: php scripts/test_login_performance.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Login Performance Analysis ===\n\n";

// Test 1: Database Connection
$tDb = microtime(true);
try {
    DB::connection()->getPdo();
    $dbTime = round((microtime(true) - $tDb) * 1000, 2);
    echo "✓ Database connection: {$dbTime}ms\n";
} catch (\Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}

// Test 2: Setting::getSettings() - This is called during login
$tSettings = microtime(true);
try {
    $settings = \App\Models\Setting::getSettings();
    $settingsTime = round((microtime(true) - $tSettings) * 1000, 2);
    echo "✓ Setting::getSettings(): {$settingsTime}ms\n";
    
    // Check if it's cached
    $tSettingsCached = microtime(true);
    $settings2 = \App\Models\Setting::getSettings();
    $settingsCachedTime = round((microtime(true) - $tSettingsCached) * 1000, 2);
    echo "  └─ Cached call: {$settingsCachedTime}ms\n";
} catch (\Exception $e) {
    echo "✗ Setting::getSettings() failed: " . $e->getMessage() . "\n";
}

// Test 3: User lookup (typical login query)
$tUser = microtime(true);
try {
    $user = \App\Models\User::where('username', 'admin')
        ->whereNull('deleted_at')
        ->where('activated', 1)
        ->first();
    $userTime = round((microtime(true) - $tUser) * 1000, 2);
    echo "✓ User lookup query: {$userTime}ms\n";
} catch (\Exception $e) {
    echo "✗ User lookup failed: " . $e->getMessage() . "\n";
}

// Test 4: Cache performance
$tCache = microtime(true);
Cache::put('test_login_perf', 'test_value', 60);
$cacheWriteTime = round((microtime(true) - $tCache) * 1000, 2);
echo "✓ Cache write: {$cacheWriteTime}ms\n";

$tCacheRead = microtime(true);
$cached = Cache::get('test_login_perf');
$cacheReadTime = round((microtime(true) - $tCacheRead) * 1000, 2);
echo "✓ Cache read: {$cacheReadTime}ms\n";
Cache::forget('test_login_perf');

// Test 5: Session performance
$tSession = microtime(true);
session()->put('test_login_perf', 'test_value');
$sessionWriteTime = round((microtime(true) - $tSession) * 1000, 2);
echo "✓ Session write: {$sessionWriteTime}ms\n";

$tSessionRead = microtime(true);
$sessionVal = session()->get('test_login_perf');
$sessionReadTime = round((microtime(true) - $tSessionRead) * 1000, 2);
echo "✓ Session read: {$sessionReadTime}ms\n";
session()->forget('test_login_perf');

// Test 6: Check if LDAP is enabled (can cause slowness)
echo "\n=== Configuration Check ===\n";
echo "LDAP enabled: " . ($settings->ldap_enabled ?? 'N/A') . "\n";
echo "SAML enabled: " . ($settings->saml_enabled ?? 'N/A') . "\n";
echo "Cache driver: " . config('cache.default') . "\n";
echo "Session driver: " . config('session.driver') . "\n";
echo "Login profiling: " . (env('LOGIN_PROFILING') ? 'enabled' : 'disabled') . "\n";

// Summary
echo "\n=== Performance Summary ===\n";
$totalEstimated = $dbTime + $settingsTime + $userTime + $cacheWriteTime + $sessionWriteTime;
echo "Estimated login overhead: ~{$totalEstimated}ms\n";

if ($totalEstimated > 500) {
    echo "\n⚠ WARNING: Login might be slow!\n";
    if ($dbTime > 100) {
        echo "  - Database is slow ({$dbTime}ms). Check network/DB server.\n";
    }
    if ($settingsTime > 100) {
        echo "  - Settings query is slow ({$settingsTime}ms). Consider caching.\n";
    }
} else {
    echo "\n✓ Performance looks good!\n";
}

echo "\n💡 TIP: Check storage/logs/laravel.log for LOGIN_PROF entries to see actual login times.\n";
