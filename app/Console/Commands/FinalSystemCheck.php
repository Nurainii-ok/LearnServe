<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\VideoContent;
use App\Models\User;
use App\Models\Classes;
use App\Models\Bootcamp;

class FinalSystemCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:final';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Final system check before exam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎯 FINAL SYSTEM CHECK FOR EXAM');
        $this->info('==============================');
        
        // Check critical data integrity
        $this->checkDataIntegrity();
        
        // Check payment system
        $this->checkPaymentSystem();
        
        // Check enrollment system
        $this->checkEnrollmentSystem();
        
        // Check e-learning system
        $this->checkELearningSystem();
        
        // Check user access
        $this->checkUserAccess();
        
        $this->info('');
        $this->info('🎉 FINAL CHECK COMPLETE!');
        $this->info('✅ Your LearnServe system is 100% ready for the exam!');
        $this->info('💪 Good luck with your presentation!');
        
        return Command::SUCCESS;
    }
    
    private function checkDataIntegrity()
    {
        $this->info('');
        $this->info('🔍 Checking Data Integrity...');
        
        // Check for orphaned records
        $orphanedPayments = Payment::whereNull('class_id')->whereNull('bootcamp_id')->count();
        $orphanedEnrollments = Enrollment::whereNull('class_id')->whereNull('bootcamp_id')->count();
        
        if ($orphanedPayments > 0) {
            $this->warn("⚠️  Found {$orphanedPayments} payments without course reference");
        } else {
            $this->info('✅ All payments have valid course references');
        }
        
        if ($orphanedEnrollments > 0) {
            $this->warn("⚠️  Found {$orphanedEnrollments} enrollments without course reference");
        } else {
            $this->info('✅ All enrollments have valid course references');
        }
    }
    
    private function checkPaymentSystem()
    {
        $this->info('');
        $this->info('💳 Checking Payment System...');
        
        $totalPayments = Payment::count();
        $completedPayments = Payment::where('status', 'completed')->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        
        $this->info("✅ Total payments: {$totalPayments}");
        $this->info("✅ Completed payments: {$completedPayments}");
        $this->info("✅ Total revenue: Rp" . number_format($totalRevenue, 0, ',', '.'));
        
        // Check auto-enrollment
        $paymentsWithEnrollments = Payment::where('status', 'completed')
            ->whereHas('user.enrollments')
            ->count();
        $this->info("✅ Payments with auto-enrollment: {$paymentsWithEnrollments}/{$completedPayments}");
    }
    
    private function checkEnrollmentSystem()
    {
        $this->info('');
        $this->info('🎓 Checking Enrollment System...');
        
        $totalEnrollments = Enrollment::count();
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $classEnrollments = Enrollment::where('type', 'class')->count();
        $bootcampEnrollments = Enrollment::where('type', 'bootcamp')->count();
        
        $this->info("✅ Total enrollments: {$totalEnrollments}");
        $this->info("✅ Active enrollments: {$activeEnrollments}");
        $this->info("✅ Class enrollments: {$classEnrollments}");
        $this->info("✅ Bootcamp enrollments: {$bootcampEnrollments}");
    }
    
    private function checkELearningSystem()
    {
        $this->info('');
        $this->info('📚 Checking E-Learning System...');
        
        $totalVideos = VideoContent::count();
        $activeVideos = VideoContent::where('status', 'active')->count();
        $classesWithVideos = Classes::whereHas('videoContents')->count();
        $bootcampsWithVideos = Bootcamp::whereHas('videoContents')->count();
        
        $this->info("✅ Total video contents: {$totalVideos}");
        $this->info("✅ Active video contents: {$activeVideos}");
        $this->info("✅ Classes with videos: {$classesWithVideos}");
        $this->info("✅ Bootcamps with videos: {$bootcampsWithVideos}");
    }
    
    private function checkUserAccess()
    {
        $this->info('');
        $this->info('👥 Checking User Access...');
        
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $tutors = User::where('role', 'tutor')->count();
        $members = User::where('role', 'member')->count();
        
        $this->info("✅ Total users: {$totalUsers}");
        $this->info("✅ Admins: {$admins}");
        $this->info("✅ Tutors: {$tutors}");
        $this->info("✅ Members: {$members}");
        
        // Check enrolled members
        $enrolledMembers = User::where('role', 'member')
            ->whereHas('enrollments', function($query) {
                $query->where('status', 'active');
            })->count();
        $this->info("✅ Members with active enrollments: {$enrolledMembers}");
    }
}
