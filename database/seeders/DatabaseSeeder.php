<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@learnserve.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Tutor Satu',
            'email' => 'tutor@learnserve.com',
            'password' => Hash::make('tutor'),
            'role' => 'tutor',
        ]);
        User::create([
            'name' => 'Member Satu',
            'email' => 'member@learnserve.com',
            'password' => Hash::make('member'),
            'role' => 'member',
        ]);

    }
}
