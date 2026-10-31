<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('admin:create', function () {
    $name = $this->ask('Name');
    $email = $this->ask('Email');
    $phone = $this->ask('Phone / username');
    $password = $this->secret('Password (min 8 characters)');

    if (! $email || ! $phone || strlen((string) $password) < 8) {
        return $this->error('Email, phone and a password of at least 8 characters are required.');
    }
    if (User::where('email', $email)->orWhere('username', $phone)->exists()) {
        return $this->error('A user with this email or username already exists.');
    }

    $user = new User;
    $user->forceFill([
        'group_id' => (int) config('permissions.super_group'),
        'name' => $name ?: 'Admin',
        'username' => $phone,
        'email' => $email,
        'phone' => $phone,
        'password' => Hash::make($password),
        'active' => 'yes',
        'type' => 'admin',
        'seen' => 'no',
    ])->save();

    $this->info("Admin created. Log in at ".url('trika/login')." with username {$phone}.");
})->purpose('Create an admin user in the top admin group');
