<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@learnserve.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create tutor user
        User::create([
            'name' => 'John Tutor',
            'email' => 'tutor@learnserve.com',
            'password' => Hash::make('tutor123'),
            'role' => 'tutor'
        ]);

        // Create member user
        User::create([
            'name' => 'Jane Member',
            'email' => 'member@learnserve.com',
            'password' => Hash::make('member123'),
            'role' => 'member'
        ]);

        $this->command->info('Sample users created successfully!');
    }
}