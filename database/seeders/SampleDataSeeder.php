<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classes;
use App\Models\Bootcamp;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create tutors
        $tutor1 = User::create([
            'name' => 'Dr. Ahmad Rahman',
            'email' => 'ahmad@tutor.com',
            'password' => Hash::make('password'),
            'role' => 'tutor'
        ]);

        $tutor2 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@tutor.com',
            'password' => Hash::make('password'),
            'role' => 'tutor'
        ]);

        // Create sample classes
        Classes::create([
            'title' => 'Digital Marketing Masterclass',
            'description' => 'Pelajari strategi pemasaran digital terkini untuk meningkatkan bisnis Anda. Mulai dari SEO, social media marketing, hingga Google Ads.',
            'tutor_id' => $tutor1->id,
            'capacity' => 50,
            'enrolled' => 15,
            'price' => 299000,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(37),
            'schedule' => 'Senin & Rabu, 19:00-21:00',
            'status' => 'active',
            'category' => 'Digital Marketing'
        ]);

        Classes::create([
            'title' => 'Full Stack Web Development',
            'description' => 'Belajar menjadi developer web full stack dengan menguasai HTML, CSS, JavaScript, PHP, dan Laravel framework.',
            'tutor_id' => $tutor2->id,
            'capacity' => 30,
            'enrolled' => 8,
            'price' => 599000,
            'start_date' => now()->addDays(14),
            'end_date' => now()->addDays(104),
            'schedule' => 'Selasa & Kamis, 20:00-22:00',
            'status' => 'active',
            'category' => 'Web Development'
        ]);

        Classes::create([
            'title' => 'Data Science dengan Python',
            'description' => 'Analisis data menggunakan Python, pandas, numpy, dan machine learning untuk mengolah big data.',
            'tutor_id' => $tutor1->id,
            'capacity' => 25,
            'enrolled' => 12,
            'price' => 450000,
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(70),
            'schedule' => 'Sabtu, 09:00-12:00',
            'status' => 'active',
            'category' => 'Data Science'
        ]);

        Classes::create([
            'title' => 'Microsoft Excel Advanced',
            'description' => 'Kuasai fitur advanced Excel untuk analisis data, pivot table, macro, dan dashboard yang powerful.',
            'tutor_id' => $tutor2->id,
            'capacity' => 40,
            'enrolled' => 22,
            'price' => 0, // Free course
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(23),
            'schedule' => 'Minggu, 14:00-16:00',
            'status' => 'active',
            'category' => 'Office Skills'
        ]);

        // Create sample bootcamps
        Bootcamp::create([
            'title' => 'Intensive Full Stack JavaScript Bootcamp',
            'description' => 'Program intensif 12 minggu untuk menjadi full stack developer menggunakan JavaScript, Node.js, React, dan MongoDB.',
            'tutor_id' => $tutor2->id,
            'capacity' => 20,
            'enrolled' => 5,
            'price' => 2500000,
            'start_date' => now()->addDays(21),
            'end_date' => now()->addDays(105),
            'duration' => '12 minggu',
            'status' => 'active',
            'category' => 'Programming',
            'level' => 'intermediate',
            'requirements' => 'Dasar HTML/CSS, pemahaman logika programming'
        ]);

        Bootcamp::create([
            'title' => 'UI/UX Design Bootcamp',
            'description' => 'Bootcamp desain UI/UX komprehensif dengan Figma, Adobe XD, dan prinsip design thinking untuk menciptakan pengalaman pengguna yang luar biasa.',
            'tutor_id' => $tutor1->id,
            'capacity' => 15,
            'enrolled' => 3,
            'price' => 1800000,
            'start_date' => now()->addDays(28),
            'end_date' => now()->addDays(84),
            'duration' => '8 minggu',
            'status' => 'active',
            'category' => 'Design',
            'level' => 'beginner',
            'requirements' => 'Tidak ada, cocok untuk pemula'
        ]);

        Bootcamp::create([
            'title' => 'Data Science & Machine Learning Bootcamp',
            'description' => 'Program intensif data science dengan Python, TensorFlow, dan real-world projects untuk menjadi data scientist profesional.',
            'tutor_id' => $tutor1->id,
            'capacity' => 12,
            'enrolled' => 2,
            'price' => 3200000,
            'start_date' => now()->addDays(35),
            'end_date' => now()->addDays(119),
            'duration' => '12 minggu',
            'status' => 'active',
            'category' => 'Data Science',
            'level' => 'advanced',
            'requirements' => 'Dasar Python, statistik, dan matematika'
        ]);
    }
}
