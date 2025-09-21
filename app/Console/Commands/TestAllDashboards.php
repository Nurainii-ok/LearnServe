<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\MemberController;

class TestAllDashboards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:dashboards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test all dashboard controllers for errors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== TESTING ALL DASHBOARDS ===');
        
        // Test Admin Dashboard
        $this->info('Testing Admin Dashboard...');
        try {
            session(['user_id' => 1, 'role' => 'admin']);
            $adminController = new AdminController();
            $result = $adminController->dashboard();
            $this->info('✓ Admin Dashboard: OK');
        } catch (\Exception $e) {
            $this->error('✗ Admin Dashboard Error: ' . $e->getMessage());
        }
        
        // Test Tutor Dashboard
        $this->info('Testing Tutor Dashboard...');
        try {
            session(['user_id' => 2, 'role' => 'tutor']);
            $tutorController = new TutorController();
            $result = $tutorController->dashboard();
            $this->info('✓ Tutor Dashboard: OK');
        } catch (\Exception $e) {
            $this->error('✗ Tutor Dashboard Error: ' . $e->getMessage());
        }
        
        // Test Member Dashboard
        $this->info('Testing Member Dashboard...');
        try {
            session(['user_id' => 7, 'role' => 'member']);
            $memberController = new MemberController();
            $result = $memberController->dashboard();
            $this->info('✓ Member Dashboard: OK');
        } catch (\Exception $e) {
            $this->error('✗ Member Dashboard Error: ' . $e->getMessage());
        }
        
        $this->info('');
        $this->info('=== TESTING COMPLETE ===');
        
        return Command::SUCCESS;
    }
}
