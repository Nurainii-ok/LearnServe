<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\BootcampUser;
use App\Models\Certificate;
use App\Models\Bootcamp;
use App\Models\User;

class TestBootcampSystem extends Command
{
    protected $signature = 'test:bootcamp-system';
    protected $description = 'Test the bootcamp task management system';

    public function handle()
    {
        $this->info('🧪 Testing Bootcamp Task Management System...');
        $this->newLine();

        // Test 1: Check Models
        $this->info('1. Testing Models...');
        
        try {
            $taskCount = Task::count();
            $submissionCount = TaskSubmission::count();
            $bootcampUserCount = BootcampUser::count();
            $certificateCount = Certificate::count();
            
            $this->info("   ✅ Tasks: {$taskCount}");
            $this->info("   ✅ Submissions: {$submissionCount}");
            $this->info("   ✅ Bootcamp Users: {$bootcampUserCount}");
            $this->info("   ✅ Certificates: {$certificateCount}");
        } catch (\Exception $e) {
            $this->error("   ❌ Model Error: " . $e->getMessage());
            return;
        }

        // Test 2: Check Controllers
        $this->info('2. Testing Controllers...');
        
        try {
            $controller = new \App\Http\Controllers\BootcampTaskController();
            $this->info("   ✅ BootcampTaskController: OK");
        } catch (\Exception $e) {
            $this->error("   ❌ Controller Error: " . $e->getMessage());
        }

        // Test 3: Check Routes
        $this->info('3. Testing Routes...');
        
        $routes = [
            'member.bootcamp-tasks',
            'tutor.bootcamp-tasks',
            'admin.bootcamp-tasks',
            'certificate.verify'
        ];
        
        foreach ($routes as $routeName) {
            try {
                $url = route($routeName, ['bootcamp' => 1, 'task' => 1, 'code' => 'TEST'], false);
                $this->info("   ✅ Route: {$routeName}");
            } catch (\Exception $e) {
                $this->warn("   ⚠️  Route {$routeName}: " . $e->getMessage());
            }
        }

        // Test 4: Check Database Tables
        $this->info('4. Testing Database Tables...');
        
        try {
            $tables = [
                'tasks',
                'task_submissions', 
                'bootcamp_users',
                'certificates'
            ];
            
            foreach ($tables as $table) {
                $count = \DB::table($table)->count();
                $this->info("   ✅ Table '{$table}': {$count} records");
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Database Error: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 Bootcamp System Test Complete!');
        
        return 0;
    }
}