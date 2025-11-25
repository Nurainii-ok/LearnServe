<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Task;

class CreateSampleEnrollment extends Command
{
    protected $signature = 'create:sample-enrollment';
    protected $description = 'Create sample enrollment for testing task submissions';

    public function handle()
    {
        $this->info('🎓 Creating Sample Enrollment...');
        
        // Get first member and first class
        $member = User::where('role', 'member')->first();
        $class = Classes::first();
        
        if (!$member) {
            $this->error('❌ No member found. Please create a member user first.');
            return;
        }
        
        if (!$class) {
            $this->error('❌ No class found. Please create a class first.');
            return;
        }
        
        // Check if enrollment already exists
        $existingEnrollment = Enrollment::where('user_id', $member->id)
                                       ->where('class_id', $class->id)
                                       ->first();
        
        if ($existingEnrollment) {
            $this->info("✅ Enrollment already exists: {$member->name} -> {$class->title}");
        } else {
            // Create enrollment
            $enrollment = Enrollment::create([
                'user_id' => $member->id,
                'class_id' => $class->id,
                'bootcamp_id' => null,
                'type' => 'class',
                'status' => 'active',
                'enrolled_at' => now(),
                'progress' => 0.00,
            ]);
            
            $this->info("✅ Created enrollment: {$member->name} -> {$class->title}");
        }
        
        // Show tasks available for this class
        $tasks = Task::where('class_id', $class->id)->get();
        
        $this->info("📝 Available tasks in {$class->title}:");
        foreach ($tasks as $task) {
            $this->info("   - {$task->title} (Due: {$task->due_date->format('M d, Y')})");
        }
        
        $this->newLine();
        $this->info('🎉 Sample enrollment created successfully!');
        $this->info('Now you can test task submissions.');
        
        return 0;
    }
}