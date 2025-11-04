<?php
// Test minimal bootstrap tanpa load routes/console
ini_set('display_errors', '1');
ini_set('max_execution_time', '30');
error_reporting(E_ALL);

echo "1. Testing autoload...\n";
require __DIR__ . '/../vendor/autoload.php';
echo "   ✓ autoload ok\n";

echo "2. Testing app bootstrap...\n";
$app = require __DIR__ . '/../bootstrap/app.php';
echo "   ✓ app ok\n";

echo "3. Testing kernel creation...\n";
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
echo "   ✓ kernel ok\n";

echo "4. Testing bootstrap (loads config, providers, etc)...\n";
try {
    $kernel->bootstrap();
    echo "   ✓ bootstrap ok\n";
} catch (\Throwable $e) {
    echo "   ✗ FAILED: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo "   at " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}

echo "\n✓ All checks passed!\n";
