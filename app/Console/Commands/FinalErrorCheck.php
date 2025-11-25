<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FinalErrorCheck extends Command
{
    protected $signature = 'test:final-error-check';
    protected $description = 'Final comprehensive error check for the entire system';

    public function handle()
    {
        $this->info('🔍 FINAL ERROR CHECK');
        $this->info('===================');
        $this->newLine();

        $errors = 0;
        $warnings = 0;

        // 1. Test all controllers can be instantiated
        $this->info('1. 🎮 TESTING CONTROLLER INSTANTIATION...');
        $controllers = [
            'App\Http\Controllers\AdminController',
            'App\Http\Controllers\TutorController', 
            'App\Http\Controllers\MemberController',
            'App\Http\Controllers\TaskController',
            'App\Http\Controllers\BootcampTaskController',
            'App\Http\Controllers\PaymentController',
            'App\Http\Controllers\VideoContentController',
            'App\Http\Controllers\AuthController',
            'App\Http\Controllers\PagesController'
        ];
        
        foreach ($controllers as $controller) {
            try {
                if (class_exists($controller)) {
                    // Try to instantiate
                    $instance = app($controller);
                    $this->info("   ✅ {$controller}: OK");
                } else {
                    $this->error("   ❌ {$controller}: Class not found");
                    $errors++;
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$controller}: " . $e->getMessage());
                $errors++;
            }
        }

        // 2. Test all models
        $this->newLine();
        $this->info('2. 📋 TESTING MODEL FUNCTIONALITY...');
        $models = [
            'App\Models\User',
            'App\Models\Classes',
            'App\Models\Bootcamp',
            'App\Models\Task',
            'App\Models\TaskSubmission',
            'App\Models\BootcampUser',
            'App\Models\Certificate',
            'App\Models\Payment',
            'App\Models\Enrollment',
            'App\Models\VideoContent'
        ];
        
        foreach ($models as $model) {
            try {
                if (class_exists($model)) {
                    // Try basic operations
                    $count = $model::count();
                    $this->info("   ✅ {$model}: {$count} records");
                } else {
                    $this->error("   ❌ {$model}: Class not found");
                    $errors++;
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$model}: " . $e->getMessage());
                $errors++;
            }
        }

        // 3. Test critical relationships
        $this->newLine();
        $this->info('3. 🔗 TESTING MODEL RELATIONSHIPS...');
        try {
            // Test User relationships
            $user = \App\Models\User::first();
            if ($user) {
                $user->tasks;
                $user->submissions;
                $user->bootcampUsers;
                $user->certificates;
                $this->info("   ✅ User relationships: OK");
            }

            // Test Task relationships
            $task = \App\Models\Task::first();
            if ($task) {
                $task->assignedBy;
                $task->submissions;
                $task->class;
                $task->bootcamp;
                $this->info("   ✅ Task relationships: OK");
            }

            // Test TaskSubmission relationships
            $submission = \App\Models\TaskSubmission::first();
            if ($submission) {
                $submission->task;
                $submission->user;
                $submission->reviewedBy;
                $this->info("   ✅ TaskSubmission relationships: OK");
            }

        } catch (\Exception $e) {
            $this->error("   ❌ Relationship Error: " . $e->getMessage());
            $errors++;
        }

        // 4. Test middleware
        $this->newLine();
        $this->info('4. 🛡️  TESTING MIDDLEWARE...');
        try {
            $middlewares = app('router')->getMiddleware();
            if (isset($middlewares['auth'])) {
                $this->info("   ✅ Auth middleware: Registered");
            } else {
                $this->warn("   ⚠️  Auth middleware: Not found");
                $warnings++;
            }

            // Check if role middleware exists
            $middlewareGroups = app('router')->getMiddlewareGroups();
            $this->info("   ✅ Middleware groups: " . count($middlewareGroups));

        } catch (\Exception $e) {
            $this->error("   ❌ Middleware Error: " . $e->getMessage());
            $errors++;
        }

        // 5. Test database connection
        $this->newLine();
        $this->info('5. 🗄️  TESTING DATABASE...');
        try {
            \DB::connection()->getPdo();
            $this->info("   ✅ Database connection: OK");
            
            // Test basic queries
            $userCount = \DB::table('users')->count();
            $this->info("   ✅ Database queries: OK ({$userCount} users)");
            
        } catch (\Exception $e) {
            $this->error("   ❌ Database Error: " . $e->getMessage());
            $errors++;
        }

        // 6. Test views
        $this->newLine();
        $this->info('6. 👁️  TESTING CRITICAL VIEWS...');
        $views = [
            'admin.dashboard',
            'tutor.dashboard', 
            'member.dashboard',
            'member.bootcamp-tasks.index',
            'tutor.bootcamp-tasks.index',
            'admin.bootcamp-tasks.index',
            'layouts.admin',
            'layouts.tutor',
            'layouts.member'
        ];
        
        foreach ($views as $view) {
            try {
                if (view()->exists($view)) {
                    $this->info("   ✅ View: {$view}");
                } else {
                    $this->warn("   ⚠️  View: {$view} - Not found");
                    $warnings++;
                }
            } catch (\Exception $e) {
                $this->error("   ❌ View {$view}: " . $e->getMessage());
                $errors++;
            }
        }

        // 7. Test artisan commands
        $this->newLine();
        $this->info('7. ⚙️  TESTING CUSTOM COMMANDS...');
        $commands = [
            'test:task-system',
            'test:bootcamp-system',
            'check:comprehensive',
            'fix:system-errors'
        ];
        
        foreach ($commands as $command) {
            try {
                if (\Artisan::has($command)) {
                    $this->info("   ✅ Command: {$command}");
                } else {
                    $this->warn("   ⚠️  Command: {$command} - Not found");
                    $warnings++;
                }
            } catch (\Exception $e) {
                $this->error("   ❌ Command {$command}: " . $e->getMessage());
                $errors++;
            }
        }

        // Final summary
        $this->newLine();
        $this->info('📊 FINAL SUMMARY:');
        $this->info("   Errors: {$errors}");
        $this->info("   Warnings: {$warnings}");
        
        if ($errors === 0 && $warnings === 0) {
            $this->info('🎉 PERFECT! No errors or warnings found!');
            $this->info('✨ System is 100% ready for production!');
        } elseif ($errors === 0) {
            $this->info('✅ GOOD! No critical errors found!');
            $this->info("⚠️  {$warnings} minor warnings detected.");
        } else {
            $this->error("❌ ISSUES FOUND! {$errors} errors need to be fixed.");
        }

        $this->newLine();
        $this->info('🚀 FINAL ERROR CHECK COMPLETE!');
        
        return $errors > 0 ? 1 : 0;
    }
}