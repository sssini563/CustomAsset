<?php
/**
 * Check LDAP Sync Results
 * Usage: php scripts/check-ldap-sync-results.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

echo "=== Check LDAP Sync Results ===\n\n";

$settings = Setting::first();

echo "LDAP Settings:\n";
echo "  LDAP Enabled: " . ($settings->ldap_enabled ? 'Yes' : 'No') . "\n";
echo "  Base DN: {$settings->ldap_basedn}\n";
echo "  Default Group: " . ($settings->ldap_default_group ?? 'None') . "\n\n";

// Check total users
$totalUsers = User::count();
$ldapUsers = User::where('ldap_import', 1)->count();
$localUsers = User::where('ldap_import', 0)->orWhereNull('ldap_import')->count();

echo "User Statistics:\n";
echo "  Total Users: {$totalUsers}\n";
echo "  LDAP Users: {$ldapUsers}\n";
echo "  Local Users: {$localUsers}\n\n";

// Check recent users
echo "Recent Users (last 10):\n";
echo str_repeat("-", 70) . "\n";

$recentUsers = User::orderBy('created_at', 'desc')
    ->limit(10)
    ->get(['id', 'username', 'first_name', 'last_name', 'email', 'ldap_import', 'created_at']);

foreach ($recentUsers as $user) {
    $source = $user->ldap_import ? '[LDAP]' : '[LOCAL]';
    $name = trim($user->first_name . ' ' . $user->last_name);
    echo "{$source} {$user->username} - {$name} ({$user->email})\n";
    echo "        Created: {$user->created_at}\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "LDAP Sync Test:\n\n";

// Test LDAP sync with details
echo "Running: php artisan snipeit:ldap-sync --summary\n\n";

// Run sync command and capture output
ob_start();
\Illuminate\Support\Facades\Artisan::call('snipeit:ldap-sync', ['--summary' => true]);
$output = ob_get_clean();
$consoleOutput = \Illuminate\Support\Facades\Artisan::output();

echo $consoleOutput;

echo "\n" . str_repeat("=", 70) . "\n";
echo "DIAGNOSIS:\n\n";

if ($ldapUsers == 0) {
    echo "⚠️  No LDAP users found in database.\n\n";
    echo "Possible reasons:\n";
    echo "1. LDAP sync hasn't created users yet (only imports existing usernames)\n";
    echo "2. Users need to login first to be created\n";
    echo "3. LDAP sync is set to 'update only' mode\n\n";
    
    echo "SOLUTIONS:\n";
    echo "A. Have users login with their LDAP credentials (auto-create on first login)\n";
    echo "B. Check Settings > LDAP > 'Create users on login' option\n";
    echo "C. Manually create a user with LDAP username, then sync will update it\n";
} else {
    echo "✅ {$ldapUsers} LDAP users already in system\n";
    echo "LDAP sync updates existing users, doesn't auto-create new ones.\n";
    echo "New users will be created when they login for the first time.\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "LDAP User Creation Settings:\n\n";

// Check relevant settings
$relevantSettings = [
    'ldap_enabled' => $settings->ldap_enabled,
    'ldap_pw_sync' => $settings->ldap_pw_sync,
    'ldap_default_group' => $settings->ldap_default_group,
];

foreach ($relevantSettings as $key => $value) {
    echo "  {$key}: " . ($value ?: 'Not set') . "\n";
}

echo "\n";
