<?php
namespace Database\Factories;

use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class TutorFactory extends Factory
{
    protected $model = Tutor::class;

    public function definition(): array
    {
        return [
            'name'     => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('tutor123'),
            'expertise'=> $this->faker->randomElement([
                'Web Development',
                'Data Science',
                'UI/UX Design',
                'Cyber Security',
                'Mobile Development'
            ]),
            'role'     => 'tutor',
        ];
    }

    public function defaultTutor()
    {
        return $this->state([
            'name'     => 'Tutor Utama',
            'email'    => 'tutor@gmail.com',
            'password' => Hash::make('tutor'),
            'expertise'=> 'Web Development',
            'role'     => 'tutor',
        ]);
    }
}
