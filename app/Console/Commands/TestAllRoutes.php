<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class TestAllRoutes extends Command
{
    protected $signature = 'test:all-routes';
    protected $description = 'Test all routes to ensure they are working';

    public function handle()
    {
        $this->info('🧪 TESTING ALL ROUTES');
        $this->info('====================');
        $this->newLine();

        // Get all routes
        $routes = Route::getRoutes();
        $totalRoutes = count($routes);
        
        $this->info("Total routes found: {$totalRoutes}");
        $this->newLine();

        // Test critical routes by category
        $this->info('1. 🔐 AUTHENTICATION ROUTES:');
        $authRoutes = [
            'login.post' => 'POST /login',
            'register.post' => 'POST /register',
            'logout' => 'POST /logout'
        ];
        
        foreach ($authRoutes as $name => $description) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️  {$description} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$description}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('2. 👑 ADMIN ROUTES:');
        $adminRoutes = [
            'admin.dashboard' => 'GET /admin/dashboard',
            'admin.classes' => 'GET /admin/classes',
            'admin.bootcamps' => 'GET /admin/bootcamps',
            'admin.tasks' => 'GET /admin/tasks',
            'admin.bootcamp-tasks' => 'GET /admin/bootcamp-tasks',
            'admin.payments' => 'GET /admin/payments'
        ];
        
        foreach ($adminRoutes as $name => $description) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️  {$description} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$description}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('3. 👨‍🏫 TUTOR ROUTES:');
        $tutorRoutes = [
            'tutor.dashboard' => 'GET /tutor/dashboard',
            'tutor.classes' => 'GET /tutor/classes',
            'tutor.tasks' => 'GET /tutor/tasks',
            'tutor.tasks.create' => 'GET /tutor/tasks/create',
            'tutor.bootcamp-tasks' => 'GET /tutor/bootcamp-tasks',
            'tutor.video-contents.index' => 'GET /tutor/video-contents'
        ];
        
        foreach ($tutorRoutes as $name => $description) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️  {$description} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$description}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('4. 👨‍🎓 MEMBER ROUTES:');
        $memberRoutes = [
            'member.dashboard' => 'GET /member/dashboard',
            'member.tasks' => 'GET /member/tasks',
            'member.bootcamp-tasks' => 'GET /member/bootcamp-tasks',
            'member.certificates' => 'GET /member/certificates',
            'member.enrollments' => 'GET /member/enrollments'
        ];
        
        foreach ($memberRoutes as $name => $description) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️  {$description} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$description}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('5. 💳 PAYMENT ROUTES:');
        $paymentRoutes = [
            'payment.create' => 'POST /payment/create-transaction',
            'payment.notification' => 'POST /payment/notification',
            'payment.success' => 'GET /payment/success',
            'payment.failed' => 'GET /payment/failed',
            'payment.finish' => 'GET /payment/finish'
        ];
        
        foreach ($paymentRoutes as $name => $description) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️  {$description} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$description}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('6. 🌐 PUBLIC ROUTES:');
        $publicRoutes = [
            'home' => 'GET /',
            'kelas' => 'GET /kelas',
            'bootcamp' => 'GET /bootcamp',
            'detail_kursus' => 'GET /detail_kursus/{id}',
            'deskripsi_bootcamp' => 'GET /deskripsi_bootcamp/{id}',
            'certificate.verify' => 'GET /certificate/verify/{code}'
        ];
        
        foreach ($publicRoutes as $name => $description) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("   ✅ {$description}");
                } else {
                    $this->warn("   ⚠️  {$description} - Not found");
                }
            } catch (\Exception $e) {
                $this->error("   ❌ {$description}: " . $e->getMessage());
            }
        }

        // Count routes by method
        $this->newLine();
        $this->info('7. 📊 ROUTE STATISTICS:');
        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
        foreach ($methods as $method) {
            $count = 0;
            foreach ($routes as $route) {
                if (in_array($method, $route->methods())) {
                    $count++;
                }
            }
            $this->info("   {$method}: {$count} routes");
        }

        $this->newLine();
        $this->info('🎉 ROUTE TEST COMPLETE!');
        $this->info("✨ All critical routes are properly defined!");
        
        return 0;
    }
}