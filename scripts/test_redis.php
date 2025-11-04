#!/usr/bin/env php
<?php
/**
 * Test Redis Connection & Performance
 * Usage: php scripts/test_redis.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Redis Connection Test ===\n\n";

try {
    $redis = app('redis')->connection();
    
    echo "✓ Redis connected!\n";
    echo "  Host: " . config('database.redis.default.host') . "\n";
    echo "  Port: " . config('database.redis.default.port') . "\n";
    echo "  DB: " . config('database.redis.default.database') . "\n\n";
    
    // Test write
    $startWrite = microtime(true);
    $redis->set('test_key', 'test_value');
    $writeTime = round((microtime(true) - $startWrite) * 1000, 2);
    echo "✓ Write test: {$writeTime}ms\n";
    
    // Test read
    $startRead = microtime(true);
    $value = $redis->get('test_key');
    $readTime = round((microtime(true) - $startRead) * 1000, 2);
    echo "✓ Read test: {$readTime}ms\n";
    echo "  Value: {$value}\n\n";
    
    // Test cache
    $startCache = microtime(true);
    \Cache::put('test_cache', 'cached_value', 60);
    $cacheWriteTime = round((microtime(true) - $startCache) * 1000, 2);
    echo "✓ Cache write: {$cacheWriteTime}ms\n";
    
    $startCacheRead = microtime(true);
    $cached = \Cache::get('test_cache');
    $cacheReadTime = round((microtime(true) - $startCacheRead) * 1000, 2);
    echo "✓ Cache read: {$cacheReadTime}ms\n";
    echo "  Cached value: {$cached}\n\n";
    
    // Redis info
    $info = $redis->info();
    echo "Redis Info:\n";
    echo "  Version: " . ($info['Server']['redis_version'] ?? 'N/A') . "\n";
    echo "  Uptime: " . ($info['Server']['uptime_in_seconds'] ?? 'N/A') . "s\n";
    echo "  Connected clients: " . ($info['Clients']['connected_clients'] ?? 'N/A') . "\n";
    echo "  Used memory: " . ($info['Memory']['used_memory_human'] ?? 'N/A') . "\n";
    
    // Cleanup
    $redis->del('test_key');
    \Cache::forget('test_cache');
    
    echo "\n✓ All tests passed!\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "  Make sure Redis is running and credentials are correct.\n";
    exit(1);
}
