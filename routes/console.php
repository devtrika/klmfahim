<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
 * php artisan admin:create --name="Admin" --email=me@example.com --phone=+971500000000
 *
 * Works without a terminal (e.g. Forge "Commands"): any option left out is
 * asked for when interactive; without a --password a strong one is generated
 * and printed once.
 */
Artisan::command('admin:create {--name=} {--email=} {--phone=} {--password=}', function () {
    $interactive = $this->input->isInteractive() && stream_isatty(STDIN);
    $value = fn (string $key, string $question) => $this->option($key) ?: ($interactive ? $this->ask($question) : null);

    $name = $value('name', 'Name') ?: 'Admin';
    $email = $value('email', 'Email');
    $phone = $value('phone', 'Phone / username');
    $password = $this->option('password') ?: ($interactive ? $this->secret('Password (leave empty to generate one)') : null);

    $generated = false;
    if (! $password) {
        $password = Str::password(16, symbols: false);
        $generated = true;
    }

    if (! $email || ! $phone || strlen($password) < 8) {
        return $this->error('Pass --email and --phone (and a --password of 8+ characters, or leave it out to generate one).');
    }
    if (User::where('email', $email)->orWhere('username', $phone)->exists()) {
        return $this->error('A user with this email or username already exists.');
    }

    $user = new User;
    $user->forceFill([
        'group_id' => (int) config('permissions.super_group'),
        'name' => $name,
        'username' => $phone,
        'email' => $email,
        'phone' => $phone,
        'password' => Hash::make($password),
        'active' => 'yes',
        'type' => 'admin',
        'seen' => 'no',
    ])->save();

    $this->info('Admin created.');
    $this->line('Login:    '.url('en/trika/login'));
    $this->line("Username: {$phone}");
    if ($generated) {
        $this->line("Password: {$password}");
        $this->warn('Save this password now; it is not shown again. You can change it from the admin panel.');
    }
})->purpose('Create an admin user in the top admin group');

/*
 * php artisan admin:password +971500000000 --password="new password"
 */
Artisan::command('admin:password {username} {--password=}', function () {
    $user = User::where('username', $this->argument('username'))->orWhere('email', $this->argument('username'))->first();
    if (! $user) {
        return $this->error('No user with that username or email.');
    }

    $password = (string) $this->option('password');
    if (strlen($password) < 8) {
        return $this->error('Pass --password with at least 8 characters.');
    }

    $user->forceFill(['password' => Hash::make($password)])->save();
    $this->info("Password updated for {$user->username}.");
})->purpose("Set a new password for an existing admin");
