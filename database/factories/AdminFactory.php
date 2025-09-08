<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('12345678'),
            'role'     => 'admin',
        ];
    }

    public function dataadmin1()
    {
        return $this->state([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role'     => 'admin',
        ]);
    }

    public function dataadmin2()
    {
        return $this->state([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'role'     => 'admin',
        ]);
    }
}
