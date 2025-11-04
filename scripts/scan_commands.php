<?php
ini_set('display_errors', '1');
ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$namespace = $app->getNamespace();
$base = realpath(app_path());
$dir = __DIR__ . '/../app/Console/Commands';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($rii as $file) {
    if ($file->isDir() || $file->getExtension() !== 'php') continue;
    $path = $file->getRealPath();
    $rel = substr($path, strlen($base) + 1);
    $class = $namespace . str_replace(['/', '\\', '.php'], ['\\', '\\', ''], $rel);
    $start = microtime(true);
    $ok = false;
    try {
        $ok = is_subclass_of($class, \Illuminate\Console\Command::class);
    } catch (\Throwable $e) {
        echo "ERR: $class from $rel => ".get_class($e).": ".$e->getMessage()."\n";
    }
    $dur = microtime(true) - $start;
    echo sprintf("%.3fs %s %s\n", $dur, $ok ? '[OK]' : '[--]', $class);
    if ($dur > 2.0) {
        echo "  slow file: $path\n";
    }
}
