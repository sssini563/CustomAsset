<?php
ini_set('display_errors', '1');
ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');
error_reporting(E_ALL);

$command = $argv[1] ?? 'list';

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->call($command);

$output = $kernel->output();
echo $output;
exit($status);
