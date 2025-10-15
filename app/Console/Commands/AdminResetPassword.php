<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AdminResetPassword extends Command
{
    protected $signature = 'admin:reset-password {--username=} {--email=} {--password=}';

    protected $description = 'Reset a user\'s password by username or email';

    public function handle(): int
    {
        $username = $this->option('username');
        $email = $this->option('email');
        $password = (string) ($this->option('password') ?? '');

        if (!$username && !$email) {
            $this->error('Provide --username or --email');
            return 1;
        }
        if ($password === '') {
            $password = $this->secret('New password');
        }
        if ($password === null || $password === '') {
            $this->error('Password cannot be empty');
            return 1;
        }

        $query = User::query();
        if ($username) { $query->where('username', $username); }
        if ($email) { $query->orWhere('email', $email); }

        $user = $query->first();
        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        $user->password = Hash::make($password);
        $user->saveQuietly();
        $this->info('Password updated for user: '.$user->username);
        return 0;
    }
}
