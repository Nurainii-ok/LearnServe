<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Classes;
use App\Models\User;
use App\Models\Enrollment;

class TestTaskSystem extends Command
{
    protected $signature = 'test:task-system';
    protected $description = 'Test the task management system';

    public function handle()
    {
        $this->info('🧪 Testing Task Management System...');
        $this->newLine();

        // Test 1: Check Models
        $this->info('1. Testing Models...');
        
        try {
            $taskCount = Task::count();
            $submissionCount = TaskSubmission::count();
            $this->info("   ✅ Tasks: {$taskCount}");
            $this->info("   ✅ Submissions: {$submissionCount}");
        } catch (\Exception $e) {
            $this->error("   ❌ Model Error: " . $e->getMessage());
            return;
        }

        // Test 2: Check Relationships
        $this->info('2. Testing Relationships...');
        
        try {
            $tutors = User::where('role', 'tutor')->count();
            $members = User::where('role', 'member')->count();
            $classes = Classes::count();
            $enrollments = Enrollment::count();
            
            $this->info("   ✅ Tutors: {$tutors}");
            $this->info("   ✅ Members: {$members}");
            $this->info("   ✅ Classes: {$classes}");
            $this->info("   ✅ Enrollments: {$enrollments}");
        } catch (\Exception $e) {
            $this->error("   ❌ Relationship Error: " . $e->getMessage());
            return;
        }

        // Test 3: Create Sample Task (if tutor and class exist)
        $this->info('3. Testing Task Creation...');
        
        $tutor = User::where('role', 'tutor')->first();
        $class = Classes::first();
        
        if ($tutor && $class) {
            try {
                $task = Task::create([
                    'title' => 'Test Task - ' . now()->format('Y-m-d H:i:s'),
                    'description' => 'This is a test task created by the system test.',
                    'class_id' => $class->id,
                    'assigned_by' => $tutor->id,
                    'due_date' => now()->addDays(7),
                    'priority' => 'medium',
                    'status' => 'pending',
                    'instructions' => 'Complete this test task to verify the system works.',
                ]);
                
                $this->info("   ✅ Created Task: {$task->title} (ID: {$task->id})");
            } catch (\Exception $e) {
                $this->error("   ❌ Task Creation Error: " . $e->getMessage());
                return;
            }
        } else {
            $this->warn('   ⚠️  No tutor or class found - skipping task creation test');
        }

        // Test 4: Test Task Submission (if member and enrollment exist)
        $this->info('4. Testing Task Submission...');
        
        $member = User::where('role', 'member')->first();
        $task = Task::first();
        
        if ($member && $task) {
            // Check if member is enrolled in the task's class
            $enrollment = Enrollment::where('user_id', $member->id)
                                   ->where('class_id', $task->class_id)
                                   ->first();
            
            if ($enrollment) {
                // Check if submission already exists
                $existingSubmission = TaskSubmission::where('task_id', $task->id)
                                                   ->where('user_id', $member->id)
                                                   ->first();
                
                if ($existingSubmission) {
                    $this->info("   ✅ Submission already exists: ID {$existingSubmission->id}");
                } else {
                    try {
                        $submission = TaskSubmission::create([
                            'task_id' => $task->id,
                            'user_id' => $member->id,
                            'content' => 'This is a test submission created by the system test.',
                        ]);
                        
                        $this->info("   ✅ Created Submission: ID {$submission->id}");
                    } catch (\Exception $e) {
                        $this->error("   ❌ Submission Error: " . $e->getMessage());
                    }
                }
            } else {
                $this->warn('   ⚠️  Member not enrolled in task class - skipping submission test');
            }
        } else {
            $this->warn('   ⚠️  No member or task found - skipping submission test');
        }

        // Test 5: Test Grading
        $this->info('5. Testing Grading System...');
        
        $submission = TaskSubmission::whereNull('grade')->first();
        
        if ($submission) {
            try {
                $submission->update([
                    'grade' => 85,
                    'feedback' => 'Good work! This is test feedback.',
                    'graded_at' => now(),
                    'graded_by' => $submission->task->assigned_by,
                ]);
                
                $this->info("   ✅ Graded Submission: {$submission->grade}/100 ({$submission->grade_letter})");
            } catch (\Exception $e) {
                $this->error("   ❌ Grading Error: " . $e->getMessage());
            }
        } else {
            $this->warn('   ⚠️  No ungraded submission found - skipping grading test');
        }

        // Test 6: Test Routes (basic check)
        $this->info('6. Testing Route Definitions...');
        
        try {
            $routes = [
                'tutor.tasks' => [],
                'tutor.tasks.create' => [], 
                'tutor.tasks.store' => [],
                'tutor.tasks.show' => ['task' => 1],
                'member.tasks' => [],
                'member.tasks.show' => ['task' => 1],
                'member.tasks.submit' => ['task' => 1],
                'admin.tasks' => []
            ];
            
            foreach ($routes as $routeName => $params) {
                try {
                    $url = route($routeName, $params, false);
                    $this->info("   ✅ Route: {$routeName} -> {$url}");
                } catch (\Exception $e) {
                    $this->warn("   ⚠️  Route {$routeName}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Route Error: " . $e->getMessage());
        }

        // Summary
        $this->newLine();
        $this->info('📊 System Summary:');
        $this->info("   Total Tasks: " . Task::count());
        $this->info("   Total Submissions: " . TaskSubmission::count());
        $this->info("   Graded Submissions: " . TaskSubmission::whereNotNull('grade')->count());
        $this->info("   Overdue Tasks: " . Task::where('due_date', '<', now())->where('status', '!=', 'completed')->count());
        
        $this->newLine();
        $this->info('🎉 Task Management System Test Complete!');
        
        return 0;
    }
}