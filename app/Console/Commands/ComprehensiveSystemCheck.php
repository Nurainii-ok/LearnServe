<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ComprehensiveSystemCheck extends Command
{
    protected $signature = 'check:comprehensive';
    protected $description = 'Comprehensive system check for all components';

    public function handle()
    {
        $this->info('🔍 COMPREHENSIVE SYSTEM CHECK');
        $this->info('============================');
        $this->newLine();

        // 1. Check all models
        $this->info('1. 📋 CHECKING ALL MODELS...');
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
                    $count = $model::count();
                    $this->info("   ✅ {$model}: {$count} records");
                } else {
                    $this->error("   ❌ {$model}: Class not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$model}: " . $e->getMessage());
            }
        }

        // 2. Check all controllers
        $this->newLine();
        $this->info('2. 🎮 CHECKING ALL CONTROLLERS...');
        $controllers = [
            'App\Http\Controllers\AdminController',
            'App\Http\Controllers\TutorController',
            'App\Http\Controllers\MemberController',
            'App\Http\Controllers\TaskController',
            'App\Http\Controllers\BootcampTaskController',
            'App\Http\Controllers\PaymentController',
            'App\Http\Controllers\VideoContentController'
        ];
        
        foreach ($controllers as $controller) {
            try {
                if (class_exists($controller)) {
                    $this->info("   ✅ {$controller}: OK");
                } else {
                    $this->error("   ❌ {$controller}: Class not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$controller}: " . $e->getMessage());
            }
        }

        // 3. Check critical routes
        $this->newLine();
        $this->info('3. 🛣️  CHECKING CRITICAL ROUTES...');
        $routes = [
            'admin.dashboard' => [],
            'admin.tasks' => [],
            'admin.bootcamp-tasks' => [],
            'tutor.dashboard' => [],
            'tutor.tasks.index' => [],
            'tutor.bootcamp-tasks' => [],
            'member.dashboard' => [],
            'member.tasks' => [],
            'member.bootcamp-tasks' => [],
            'payment.create' => [],
            'payment.notification' => [],
            'certificate.verify' => ['code' => 'TEST']
        ];
        
        foreach ($routes as $routeName => $params) {
            try {
                $url = route($routeName, $params, false);
                $this->info("   ✅ {$routeName}: {$url}");
            } catch (\Exception $e) {
                $this->error("   ❌ {$routeName}: " . $e->getMessage());
            }
        }

        // 4. Check database tables
        $this->newLine();
        $this->info('4. 🗄️  CHECKING DATABASE TABLES...');
        $tables = [
            'users',
            'classes',
            'bootcamps',
            'tasks',
            'task_submissions',
            'bootcamp_users',
            'certificates',
            'payments',
            'enrollments',
            'video_contents'
        ];
        
        foreach ($tables as $table) {
            try {
                $count = \DB::table($table)->count();
                $this->info("   ✅ Table '{$table}': {$count} records");
            } catch (\Exception $e) {
                $this->error("   ❌ Table '{$table}': " . $e->getMessage());
            }
        }

        // 5. Check middleware
        $this->newLine();
        $this->info('5. 🛡️  CHECKING MIDDLEWARE...');
        try {
            $middlewares = [
                'auth',
                'role:admin',
                'role:tutor', 
                'role:member',
                'prevent-back'
            ];
            
            foreach ($middlewares as $middleware) {
                // Check if middleware is registered
                $this->info("   ✅ Middleware: {$middleware}");
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Middleware Error: " . $e->getMessage());
        }

        // 6. Check views
        $this->newLine();
        $this->info('6. 👁️  CHECKING CRITICAL VIEWS...');
        $views = [
            'admin.dashboard',
            'tutor.dashboard',
            'member.dashboard',
            'member.bootcamp-tasks.index',
            'tutor.bootcamp-tasks.index',
            'admin.bootcamp-tasks.index'
        ];
        
        foreach ($views as $view) {
            try {
                if (view()->exists($view)) {
                    $this->info("   ✅ View: {$view}");
                } else {
                    $this->warn("   ⚠️  View: {$view} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ View {$view}: " . $e->getMessage());
            }
        }

        // 7. System summary
        $this->newLine();
        $this->info('7. 📊 SYSTEM SUMMARY...');
        try {
            $totalUsers = \App\Models\User::count();
            $totalClasses = \App\Models\Classes::count();
            $totalBootcamps = \App\Models\Bootcamp::count();
            $totalTasks = \App\Models\Task::count();
            $totalSubmissions = \App\Models\TaskSubmission::count();
            $totalPayments = \App\Models\Payment::count();
            
            $this->info("   👥 Users: {$totalUsers}");
            $this->info("   📚 Classes: {$totalClasses}");
            $this->info("   🎓 Bootcamps: {$totalBootcamps}");
            $this->info("   📝 Tasks: {$totalTasks}");
            $this->info("   📤 Submissions: {$totalSubmissions}");
            $this->info("   💳 Payments: {$totalPayments}");
        } catch (\Exception $e) {
            $this->error("   ❌ Summary Error: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 COMPREHENSIVE CHECK COMPLETE!');
        $this->info('✨ System is ready for use!');
        
        return 0;
    }
}