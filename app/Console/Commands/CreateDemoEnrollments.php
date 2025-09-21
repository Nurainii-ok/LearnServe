<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Classes;
use App\Models\Bootcamp;

class CreateDemoEnrollments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:enrollments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create demo enrollments for presentation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎭 Creating demo enrollments for presentation...');
        
        $members = User::where('role', 'member')->get();
        $classes = Classes::take(3)->get();
        $bootcamps = Bootcamp::take(2)->get();
        
        if ($members->count() < 3) {
            $this->error('Need at least 3 members to create demo enrollments');
            return;
        }
        
        $demoEnrollments = [
            [
                'user_id' => $members->get(2)->id ?? 3,
                'class_id' => $classes->first()->id ?? 1,
                'type' => 'class',
                'status' => 'active',
                'progress' => 75.5,
                'enrolled_at' => now()->subDays(15),
                'notes' => 'Excellent progress, very engaged student'
            ],
            [
                'user_id' => $members->get(3)->id ?? 14,
                'bootcamp_id' => $bootcamps->first()->id ?? 1,
                'type' => 'bootcamp',
                'status' => 'active',
                'progress' => 45.0,
                'enrolled_at' => now()->subDays(8),
                'notes' => 'Good participation in bootcamp activities'
            ],
            [
                'user_id' => $members->get(4)->id ?? 15,
                'class_id' => $classes->get(1)->id ?? 2,
                'type' => 'class',
                'status' => 'completed',
                'progress' => 100.0,
                'enrolled_at' => now()->subDays(30),
                'completed_at' => now()->subDays(5),
                'notes' => 'Successfully completed all course requirements'
            ],
            [
                'user_id' => $members->get(2)->id ?? 3,
                'bootcamp_id' => $bootcamps->get(1)->id ?? 2,
                'type' => 'bootcamp',
                'status' => 'pending',
                'progress' => 25.0,
                'enrolled_at' => now()->subDays(20),
                'notes' => 'Pending completion of prerequisites'
            ]
        ];
        
        $created = 0;
        foreach ($demoEnrollments as $enrollmentData) {
            // Check if enrollment already exists
            $exists = Enrollment::where('user_id', $enrollmentData['user_id'])
                ->where(function($query) use ($enrollmentData) {
                    if (isset($enrollmentData['class_id'])) {
                        $query->where('class_id', $enrollmentData['class_id']);
                    } else {
                        $query->where('bootcamp_id', $enrollmentData['bootcamp_id']);
                    }
                })
                ->exists();
                
            if (!$exists) {
                Enrollment::create($enrollmentData);
                $created++;
                
                $user = User::find($enrollmentData['user_id']);
                $course = isset($enrollmentData['class_id']) 
                    ? Classes::find($enrollmentData['class_id'])->title 
                    : Bootcamp::find($enrollmentData['bootcamp_id'])->title;
                    
                $this->info("✓ Created enrollment: {$user->name} → {$course}");
            }
        }
        
        $total = Enrollment::count();
        $this->info("🎉 Created {$created} new demo enrollments");
        $this->info("📊 Total enrollments now: {$total}");
        
        return Command::SUCCESS;
    }
}
