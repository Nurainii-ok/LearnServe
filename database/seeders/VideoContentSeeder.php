<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some classes and bootcamps
        $classes = \App\Models\Classes::take(3)->get();
        $bootcamps = \App\Models\Bootcamp::take(2)->get();
        $tutors = \App\Models\User::where('role', 'tutor')->get();
        $admin = \App\Models\User::where('role', 'admin')->first();

        // Create video content for classes
        foreach ($classes as $index => $class) {
            $tutor = $tutors->isNotEmpty() ? $tutors->random() : $admin;
            
            \App\Models\VideoContent::create([
                'title' => 'Introduction to ' . $class->title,
                'description' => 'Welcome to the course! In this video, we will introduce you to the basics of ' . $class->title . ' and what you can expect to learn.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Sample YouTube URL
                'duration' => 600, // 10 minutes
                'class_id' => $class->id,
                'order' => 1,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);

            \App\Models\VideoContent::create([
                'title' => 'Getting Started with ' . $class->title,
                'description' => 'Let\'s dive into the practical aspects and start building your first project in ' . $class->title . '.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 900, // 15 minutes
                'class_id' => $class->id,
                'order' => 2,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);

            \App\Models\VideoContent::create([
                'title' => 'Advanced Concepts in ' . $class->title,
                'description' => 'Now that you have the basics down, let\'s explore some advanced concepts and techniques.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 1200, // 20 minutes
                'class_id' => $class->id,
                'order' => 3,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);
        }

        // Create video content for bootcamps
        foreach ($bootcamps as $index => $bootcamp) {
            $tutor = $tutors->isNotEmpty() ? $tutors->random() : $admin;
            
            \App\Models\VideoContent::create([
                'title' => 'Bootcamp Orientation - ' . $bootcamp->title,
                'description' => 'Welcome to the intensive bootcamp! This orientation will prepare you for the journey ahead.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 1800, // 30 minutes
                'bootcamp_id' => $bootcamp->id,
                'order' => 1,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);

            \App\Models\VideoContent::create([
                'title' => 'Module 1: Fundamentals of ' . $bootcamp->title,
                'description' => 'Deep dive into the fundamental concepts that form the foundation of ' . $bootcamp->title . '.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 2400, // 40 minutes
                'bootcamp_id' => $bootcamp->id,
                'order' => 2,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);

            \App\Models\VideoContent::create([
                'title' => 'Module 2: Hands-on Project in ' . $bootcamp->title,
                'description' => 'Time to get your hands dirty! Build your first real-world project step by step.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 3600, // 60 minutes
                'bootcamp_id' => $bootcamp->id,
                'order' => 3,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);

            \App\Models\VideoContent::create([
                'title' => 'Module 3: Advanced Techniques and Best Practices',
                'description' => 'Learn industry best practices and advanced techniques used by professionals.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 2700, // 45 minutes
                'bootcamp_id' => $bootcamp->id,
                'order' => 4,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);

            \App\Models\VideoContent::create([
                'title' => 'Final Project and Portfolio Building',
                'description' => 'Create your capstone project and build a portfolio that will impress employers.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => 4200, // 70 minutes
                'bootcamp_id' => $bootcamp->id,
                'order' => 5,
                'status' => 'active',
                'created_by' => $tutor->id
            ]);
        }

        $this->command->info('Video content seeded successfully!');
    }
}
