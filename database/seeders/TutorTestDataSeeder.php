<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classes;
use App\Models\Task;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class TutorTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test tutor if not exists
        $tutor = User::firstOrCreate(
            ['email' => 'tutor@test.com'],
            [
                'name' => 'Test Tutor',
                'password' => Hash::make('password'),
                'role' => 'tutor'
            ]
        );

        // Create some test members if not exist
        $member1 = User::firstOrCreate(
            ['email' => 'member1@test.com'],
            [
                'name' => 'Test Member 1',
                'password' => Hash::make('password'),
                'role' => 'member'
            ]
        );

        $member2 = User::firstOrCreate(
            ['email' => 'member2@test.com'],
            [
                'name' => 'Test Member 2',
                'password' => Hash::make('password'),
                'role' => 'member'
            ]
        );

        // Create test classes
        $class1 = Classes::firstOrCreate(
            ['title' => 'Web Development Bootcamp'],
            [
                'description' => 'Complete web development course covering HTML, CSS, JavaScript, and React',
                'tutor_id' => $tutor->id,
                'capacity' => 30,
                'enrolled' => 0,
                'price' => 299000,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(37),
                'schedule' => 'Mon,Wed,Fri 19:00-21:00',
                'status' => 'active',
                'category' => 'Programming'
            ]
        );

        $class2 = Classes::firstOrCreate(
            ['title' => 'JavaScript Advanced'],
            [
                'description' => 'Advanced JavaScript concepts including ES6+, async programming, and frameworks',
                'tutor_id' => $tutor->id,
                'capacity' => 25,
                'enrolled' => 0,
                'price' => 199000,
                'start_date' => now()->addDays(14),
                'end_date' => now()->addDays(44),
                'schedule' => 'Tue,Thu 19:00-21:00',
                'status' => 'active',
                'category' => 'Programming'
            ]
        );

        // Create test payments
        Payment::firstOrCreate(
            [
                'user_id' => $member1->id,
                'class_id' => $class1->id,
                'transaction_id' => 'TXN' . time() . '001'
            ],
            [
                'amount' => 299000,
                'payment_method' => 'bank_transfer',
                'status' => 'completed',
                'payment_date' => now(),
                'notes' => 'Test payment for bootcamp'
            ]
        );

        Payment::firstOrCreate(
            [
                'user_id' => $member2->id,
                'class_id' => $class2->id,
                'transaction_id' => 'TXN' . time() . '002'
            ],
            [
                'amount' => 199000,
                'payment_method' => 'e_wallet',
                'status' => 'completed',
                'payment_date' => now()->subDays(2),
                'notes' => 'Test payment for JavaScript course'
            ]
        );

        // Create test tasks
        Task::firstOrCreate(
            ['title' => 'HTML & CSS Fundamentals'],
            [
                'description' => 'Complete the HTML and CSS basics assignment including responsive design',
                'class_id' => $class1->id,
                'assigned_by' => $tutor->id,
                'due_date' => now()->addDays(10),
                'priority' => 'medium',
                'status' => 'pending',
                'instructions' => 'Create a responsive landing page using HTML5 and CSS3'
            ]
        );

        Task::firstOrCreate(
            ['title' => 'JavaScript ES6 Features'],
            [
                'description' => 'Implement modern JavaScript features in your project',
                'class_id' => $class2->id,
                'assigned_by' => $tutor->id,
                'due_date' => now()->addDays(20),
                'priority' => 'high',
                'status' => 'pending',
                'instructions' => 'Use arrow functions, destructuring, and modules in your code'
            ]
        );

        echo "Test data created successfully!\n";
        echo "Tutor login: tutor@test.com / password\n";
        echo "Member logins: member1@test.com / password, member2@test.com / password\n";
    }
}
