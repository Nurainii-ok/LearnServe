<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'     => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'phone'    => $this->faker->phoneNumber(),
            'address'  => $this->faker->address(),
            'password' => Hash::make('member123'),
            'role'     => 'member',
        ];
    }

    public function defaultMember()
    {
        return $this->state([
            'name'     => 'Member Utama',
            'email'    => 'member@gmail.com',
            'phone'    => '08123456789',
            'address'  => 'Jl. Belajar Laravel No. 1',
            'password' => Hash::make('member'),
            'role'     => 'member',
        ]);
    }
}
