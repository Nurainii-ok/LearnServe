<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\User;

class DebugEnrollments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:enrollments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug payments and enrollments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DEBUGGING PAYMENTS AND ENROLLMENTS ===');
        
        // Check payments
        $payments = Payment::where('status', 'completed')->whereNotNull('user_id')->get();
        $this->info("Completed payments: " . $payments->count());
        
        foreach ($payments as $payment) {
            $this->line("Payment ID: {$payment->id}, User: {$payment->user_id}, Class: {$payment->class_id}, Bootcamp: {$payment->bootcamp_id}");
        }
        
        $this->info('');
        
        // Check enrollments
        $enrollments = Enrollment::with(['class', 'bootcamp'])->get();
        $this->info("Total enrollments: " . $enrollments->count());
        
        foreach ($enrollments as $enrollment) {
            $courseName = $enrollment->class ? $enrollment->class->title : ($enrollment->bootcamp ? $enrollment->bootcamp->title : 'Unknown');
            $this->line("Enrollment ID: {$enrollment->id}, User: {$enrollment->user_id}, Type: {$enrollment->type}, Course: {$courseName}");
        }
        
        $this->info('');
        
        // Check users
        $members = User::where('role', 'member')->get();
        $this->info("Total members: " . $members->count());
        
        foreach ($members as $member) {
            $memberPayments = Payment::where('user_id', $member->id)->where('status', 'completed')->count();
            $memberEnrollments = Enrollment::where('user_id', $member->id)->count();
            $this->line("Member: {$member->name} (ID: {$member->id}) - Payments: {$memberPayments}, Enrollments: {$memberEnrollments}");
        }
        
        return Command::SUCCESS;
    }
}
