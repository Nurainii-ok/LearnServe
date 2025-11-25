<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixSystemErrors extends Command
{
    protected $signature = 'fix:system-errors';
    protected $description = 'Fix common system errors and clear caches';

    public function handle()
    {
        $this->info('🔧 Fixing System Errors...');
        $this->newLine();

        // Clear all caches
        $this->info('1. Clearing Caches...');
        
        try {
            \Artisan::call('cache:clear');
            $this->info('   ✅ Cache cleared');
            
            \Artisan::call('config:clear');
            $this->info('   ✅ Config cache cleared');
            
            \Artisan::call('route:clear');
            $this->info('   ✅ Route cache cleared');
            
            \Artisan::call('view:clear');
            $this->info('   ✅ View cache cleared');
            
        } catch (\Exception $e) {
            $this->error("   ❌ Cache Error: " . $e->getMessage());
        }

        // Check autoload
        $this->info('2. Updating Autoload...');
        
        try {
            exec('composer dump-autoload', $output, $return);
            if ($return === 0) {
                $this->info('   ✅ Autoload updated');
            } else {
                $this->warn('   ⚠️  Autoload update failed');
            }
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not run composer dump-autoload');
        }

        // Check models
        $this->info('3. Testing Models...');
        
        $models = [
            'App\Models\Task',
            'App\Models\TaskSubmission',
            'App\Models\BootcampUser',
            'App\Models\Certificate',
            'App\Models\User',
            'App\Models\Bootcamp'
        ];
        
        foreach ($models as $model) {
            try {
                if (class_exists($model)) {
                    $this->info("   ✅ Model: {$model}");
                } else {
                    $this->error("   ❌ Model not found: {$model}");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ Model error {$model}: " . $e->getMessage());
            }
        }

        // Check controllers
        $this->info('4. Testing Controllers...');
        
        $controllers = [
            'App\Http\Controllers\BootcampTaskController',
            'App\Http\Controllers\TaskController',
            'App\Http\Controllers\AdminController'
        ];
        
        foreach ($controllers as $controller) {
            try {
                if (class_exists($controller)) {
                    $this->info("   ✅ Controller: {$controller}");
                } else {
                    $this->error("   ❌ Controller not found: {$controller}");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ Controller error {$controller}: " . $e->getMessage());
            }
        }

        // Check routes
        $this->info('5. Testing Routes...');
        
        try {
            $routes = \Route::getRoutes();
            $routeCount = count($routes);
            $this->info("   ✅ Total routes: {$routeCount}");
            
            // Test specific routes
            $testRoutes = [
                'admin.dashboard',
                'member.bootcamp-tasks',
                'tutor.bootcamp-tasks'
            ];
            
            foreach ($testRoutes as $routeName) {
                try {
                    $route = \Route::getRoutes()->getByName($routeName);
                    if ($route) {
                        $this->info("   ✅ Route exists: {$routeName}");
                    } else {
                        $this->warn("   ⚠️  Route not found: {$routeName}");
                    }
                } catch (\Exception $e) {
                    $this->warn("   ⚠️  Route error {$routeName}: " . $e->getMessage());
                }
            }
            
        } catch (\Exception $e) {
            $this->error("   ❌ Route Error: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 System Error Fix Complete!');
        $this->info('Try accessing the admin dashboard now.');
        
        return 0;
    }
}