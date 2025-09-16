<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bootcamp;
use App\Models\User;

class BootcampSeeder extends Seeder
{
    public function run()
    {
        // Get first tutor for assignment
        $tutor = User::where('role', 'tutor')->first();
        
        if (!$tutor) {
            $this->command->error('No tutor found. Please create a tutor first.');
            return;
        }
        
        $bootcamps = [
            [
                'title' => 'Full Stack Web Development Bootcamp',
                'description' => 'Intensive 12-week bootcamp covering HTML, CSS, JavaScript, PHP, Laravel, and React. Perfect for beginners who want to become full-stack developers.',
                'tutor_id' => $tutor->id,
                'capacity' => 25,
                'enrolled' => 8,
                'price' => 2500000,
                'start_date' => '2025-10-01 09:00:00',
                'end_date' => '2025-12-20 17:00:00',
                'duration' => '12 weeks',
                'status' => 'active',
                'category' => 'Programming',
                'level' => 'intermediate',
                'requirements' => 'Basic HTML/CSS knowledge, computer literacy, dedication to learn'
            ],
            [
                'title' => 'Data Science & Machine Learning Bootcamp',
                'description' => 'Comprehensive bootcamp covering Python, pandas, NumPy, scikit-learn, and machine learning fundamentals.',
                'tutor_id' => $tutor->id,
                'capacity' => 20,
                'enrolled' => 12,
                'price' => 3000000,
                'start_date' => '2025-11-01 09:00:00',
                'end_date' => '2026-01-31 17:00:00',
                'duration' => '14 weeks',
                'status' => 'active',
                'category' => 'Data Science',
                'level' => 'advanced',
                'requirements' => 'Basic programming knowledge, statistics background preferred'
            ],
            [
                'title' => 'Mobile App Development Bootcamp',
                'description' => 'Learn to build mobile apps using React Native and Flutter. Build real-world applications.',
                'tutor_id' => $tutor->id,
                'capacity' => 18,
                'enrolled' => 5,
                'price' => 2200000,
                'start_date' => '2025-12-01 09:00:00',
                'end_date' => '2026-02-28 17:00:00',
                'duration' => '10 weeks',
                'status' => 'active',
                'category' => 'Mobile Development',
                'level' => 'beginner',
                'requirements' => 'Basic JavaScript knowledge, willingness to learn'
            ]
        ];
        
        foreach ($bootcamps as $bootcamp) {
            Bootcamp::create($bootcamp);
        }
        
        $this->command->info('Sample bootcamps created successfully!');
    }
}