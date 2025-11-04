<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    echo "CWD: ".getcwd()."\n";
    require __DIR__ . '/../vendor/autoload.php';
    echo "autoload ok\n";
    $app = require __DIR__ . '/../bootstrap/app.php';
    echo "app ok\n";
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    echo "kernel ok\n";
    exit(0);
} catch (\Throwable $e) {
    fwrite(STDERR, "BOOTSTRAP ERROR: ".get_class($e).": ".$e->getMessage()."\n");
    fwrite(STDERR, $e->getTraceAsString()."\n");
    exit(1);
}
