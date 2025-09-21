<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Classes;
use App\Models\Bootcamp;

class TestMemberDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:member-dashboard {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test member dashboard data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        
        $this->info("=== TESTING MEMBER DASHBOARD FOR USER ID: {$userId} ===");
        
        $member = User::find($userId);
        if (!$member) {
            $this->error("User not found!");
            return;
        }
        
        $this->info("Member: {$member->name} ({$member->email})");
        
        // Get member's enrollments
        $memberEnrollments = Enrollment::where('user_id', $userId)
            ->where('status', 'active')
            ->with(['class.tutor', 'bootcamp.tutor'])
            ->latest()
            ->get();
            
        $this->info("Total active enrollments: " . $memberEnrollments->count());
        
        foreach ($memberEnrollments as $enrollment) {
            if ($enrollment->type === 'class' && $enrollment->class) {
                $this->line("- Class: {$enrollment->class->title} (Tutor: {$enrollment->class->tutor->name})");
            } elseif ($enrollment->type === 'bootcamp' && $enrollment->bootcamp) {
                $this->line("- Bootcamp: {$enrollment->bootcamp->title} (Tutor: {$enrollment->bootcamp->tutor->name})");
            }
        }
        
        $enrolledClassesCount = $memberEnrollments->where('type', 'class')->count();
        $enrolledBootcampsCount = $memberEnrollments->where('type', 'bootcamp')->count();
        
        $this->info("Classes enrolled: {$enrolledClassesCount}");
        $this->info("Bootcamps enrolled: {$enrolledBootcampsCount}");
        
        // Test E-Learning access
        $this->info("\n=== E-LEARNING ACCESS TEST ===");
        foreach ($memberEnrollments as $enrollment) {
            if ($enrollment->type === 'class' && $enrollment->class) {
                $videoCount = \App\Models\VideoContent::where('class_id', $enrollment->class->id)
                    ->where('status', 'active')
                    ->count();
                $this->line("Class '{$enrollment->class->title}' has {$videoCount} videos");
            } elseif ($enrollment->type === 'bootcamp' && $enrollment->bootcamp) {
                $videoCount = \App\Models\VideoContent::where('bootcamp_id', $enrollment->bootcamp->id)
                    ->where('status', 'active')
                    ->count();
                $this->line("Bootcamp '{$enrollment->bootcamp->title}' has {$videoCount} videos");
            }
        }
        
        return Command::SUCCESS;
    }
}
