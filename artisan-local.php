#!/usr/bin/env php
<?php

/*
|--------------------------------------------------------------------------
| Artisan Local Wrapper (No DB Required)
|--------------------------------------------------------------------------
| This wrapper allows running artisan commands without database connection
| by setting DB_CONNECTION to an array driver temporarily.
*/

// Override DB to use array driver (no connection needed)
$_ENV['DB_CONNECTION'] = 'array';
putenv('DB_CONNECTION=array');

require __DIR__.'/bootstrap/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

$kernel->terminate($input, $status);

exit($status);
