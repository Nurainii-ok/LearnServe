<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\VideoContent;

class FinalSystemStatus extends Command
{
    protected $signature = 'status:final-complete';
    protected $description = 'Complete final system status including task management';

    public function handle()
    {
        $this->info('🚀 LEARNSERVE - COMPLETE SYSTEM STATUS');
        $this->info('=====================================');
        $this->newLine();

        // 1. Core System
        $this->info('📊 CORE SYSTEM STATUS:');
        $this->info("   Users: " . User::count() . " (Admin: " . User::where('role', 'admin')->count() . 
                   ", Tutor: " . User::where('role', 'tutor')->count() . 
                   ", Member: " . User::where('role', 'member')->count() . ")");
        $this->info("   Classes: " . Classes::count() . " (Active: " . Classes::where('status', 'active')->count() . ")");
        $this->info("   Bootcamps: " . Bootcamp::count() . " (Active: " . Bootcamp::where('status', 'active')->count() . ")");
        $this->info("   Enrollments: " . Enrollment::count() . " (Active: " . Enrollment::where('status', 'active')->count() . ")");
        $this->newLine();

        // 2. Sequential ID System
        $this->info('🔢 SEQUENTIAL ID SYSTEM:');
        $classIds = Classes::orderBy('id')->pluck('id')->toArray();
        $bootcampIds = Bootcamp::orderBy('id')->pluck('id')->toArray();
        
        $classGaps = $this->checkGaps($classIds);
        $bootcampGaps = $this->checkGaps($bootcampIds);
        
        if (empty($classGaps)) {
            $this->info("   ✅ Classes: No gaps (1-" . (Classes::count() > 0 ? max($classIds) : 0) . ")");
        } else {
            $this->warn("   ⚠️  Classes: Gaps found at " . implode(', ', $classGaps));
        }
        
        if (empty($bootcampGaps)) {
            $this->info("   ✅ Bootcamps: No gaps (1-" . (Bootcamp::count() > 0 ? max($bootcampIds) : 0) . ")");
        } else {
            $this->warn("   ⚠️  Bootcamps: Gaps found at " . implode(', ', $bootcampGaps));
        }
        $this->newLine();

        // 3. Payment System
        $this->info('💳 PAYMENT SYSTEM (MIDTRANS):');
        $totalPayments = Payment::count();
        $completedPayments = Payment::where('status', 'completed')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $failedPayments = Payment::where('status', 'failed')->count();
        
        $this->info("   Total Payments: {$totalPayments}");
        $this->info("   ✅ Completed: {$completedPayments}");
        $this->info("   ⏳ Pending: {$pendingPayments}");
        $this->info("   ❌ Failed: {$failedPayments}");
        
        // Check Midtrans integration
        $midtransPayments = Payment::whereNotNull('midtrans_transaction_id')->count();
        $this->info("   🔗 Midtrans Integrated: {$midtransPayments}");
        $this->newLine();

        // 4. Task Management System
        $this->info('📝 TASK MANAGEMENT SYSTEM:');
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $overdueTasks = Task::where('due_date', '<', now())->where('status', '!=', 'completed')->count();
        
        $this->info("   Total Tasks: {$totalTasks}");
        $this->info("   📋 Pending: {$pendingTasks}");
        $this->info("   🔄 In Progress: {$inProgressTasks}");
        $this->info("   ✅ Completed: {$completedTasks}");
        $this->info("   ⚠️  Overdue: {$overdueTasks}");
        
        $totalSubmissions = TaskSubmission::count();
        $gradedSubmissions = TaskSubmission::whereNotNull('grade')->count();
        $pendingGrades = $totalSubmissions - $gradedSubmissions;
        
        $this->info("   Total Submissions: {$totalSubmissions}");
        $this->info("   ✅ Graded: {$gradedSubmissions}");
        $this->info("   ⏳ Pending Grade: {$pendingGrades}");
        $this->newLine();

        // 5. Video Content System
        $this->info('🎥 VIDEO CONTENT SYSTEM:');
        $totalVideos = VideoContent::count();
        $activeVideos = VideoContent::where('status', 'active')->count();
        $classVideos = VideoContent::whereNotNull('class_id')->count();
        $bootcampVideos = VideoContent::whereNotNull('bootcamp_id')->count();
        
        $this->info("   Total Videos: {$totalVideos}");
        $this->info("   ✅ Active: {$activeVideos}");
        $this->info("   📚 Class Videos: {$classVideos}");
        $this->info("   🎓 Bootcamp Videos: {$bootcampVideos}");
        $this->newLine();

        // 6. Route Status
        $this->info('🛣️  ROUTE STATUS:');
        $routes = [
            'Admin Routes' => [
                'admin.dashboard',
                'admin.classes',
                'admin.bootcamps',
                'admin.payments',
                'admin.tasks'
            ],
            'Tutor Routes' => [
                'tutor.dashboard',
                'tutor.tasks',
                'tutor.tasks.create',
                'tutor.video-contents.index'
            ],
            'Member Routes' => [
                'member.dashboard',
                'member.tasks',
                'member.enrollments'
            ],
            'Payment Routes' => [
                'payment.create',
                'payment.notification',
                'payment.success'
            ]
        ];

        foreach ($routes as $category => $routeList) {
            $this->info("   {$category}:");
            foreach ($routeList as $routeName) {
                try {
                    $url = route($routeName, [], false);
                    $this->info("     ✅ {$routeName}");
                } catch (\Exception $e) {
                    $this->warn("     ⚠️  {$routeName}: Not found");
                }
            }
        }
        $this->newLine();

        // 7. Database Health
        $this->info('🗄️  DATABASE HEALTH:');
        try {
            \DB::connection()->getPdo();
            $this->info("   ✅ Database Connection: OK");
            
            $tables = [
                'users', 'classes', 'bootcamps', 'payments', 'enrollments',
                'tasks', 'task_submissions', 'video_contents'
            ];
            
            foreach ($tables as $table) {
                $count = \DB::table($table)->count();
                $this->info("   ✅ Table '{$table}': {$count} records");
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Database Error: " . $e->getMessage());
        }
        $this->newLine();

        // 8. System Recommendations
        $this->info('💡 SYSTEM RECOMMENDATIONS:');
        
        if ($overdueTasks > 0) {
            $this->warn("   ⚠️  {$overdueTasks} overdue tasks need attention");
        }
        
        if ($pendingPayments > 0) {
            $this->warn("   ⚠️  {$pendingPayments} pending payments need follow-up");
        }
        
        if ($pendingGrades > 0) {
            $this->warn("   ⚠️  {$pendingGrades} submissions need grading");
        }
        
        if (!empty($classGaps) || !empty($bootcampGaps)) {
            $this->warn("   ⚠️  Sequential ID gaps detected - run fix commands");
        }
        
        if ($totalVideos === 0) {
            $this->warn("   ⚠️  No video content uploaded yet");
        }
        
        $this->newLine();
        
        // 9. Overall Status
        $issues = 0;
        if ($overdueTasks > 0) $issues++;
        if ($pendingPayments > 0) $issues++;
        if (!empty($classGaps) || !empty($bootcampGaps)) $issues++;
        
        if ($issues === 0) {
            $this->info('🎉 SYSTEM STATUS: EXCELLENT - All systems operational!');
        } elseif ($issues <= 2) {
            $this->warn('⚠️  SYSTEM STATUS: GOOD - Minor issues detected');
        } else {
            $this->error('❌ SYSTEM STATUS: NEEDS ATTENTION - Multiple issues found');
        }
        
        $this->newLine();
        $this->info('📅 Status checked on: ' . now()->format('Y-m-d H:i:s'));
        $this->info('🚀 LearnServe Platform - Ready for Production!');
        
        return 0;
    }

    private function checkGaps($ids)
    {
        if (empty($ids)) return [];
        
        $gaps = [];
        $max = max($ids);
        
        for ($i = 1; $i <= $max; $i++) {
            if (!in_array($i, $ids)) {
                $gaps[] = $i;
            }
        }
        
        return $gaps;
    }
}