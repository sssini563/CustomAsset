<?php
/**
 * Reset Admin Password
 * Usage: php scripts/reset-admin-password.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Reset Admin Password ===\n\n";

// Find admin user
$admin = User::where('username', 'admin')->first();

if (!$admin) {
    echo "❌ Admin user not found!\n";
    echo "Available users:\n";
    User::select('id', 'username', 'email', 'first_name', 'last_name')
        ->get()
        ->each(function($user) {
            echo "  - ID: {$user->id}, Username: {$user->username}, Name: {$user->first_name} {$user->last_name}\n";
        });
    exit(1);
}

// Reset password to 'admin123'
$newPassword = 'admin123';
$admin->password = Hash::make($newPassword);
$admin->save();

echo "✅ Admin password has been reset!\n";
echo "Username: {$admin->username}\n";
echo "New Password: {$newPassword}\n";
echo "\n⚠️  Please change this password after login!\n";
