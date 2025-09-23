<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;

class SimulateWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:webhook {order_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate Midtrans webhook for testing payment status update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        if (!$orderId) {
            // Show available pending payments
            $pendingPayments = Payment::where('status', 'pending')->orderBy('created_at', 'desc')->take(5)->get();
            
            if ($pendingPayments->count() > 0) {
                $this->info('📋 PENDING PAYMENTS:');
                foreach ($pendingPayments as $payment) {
                    $course = $payment->class ? $payment->class->title : ($payment->bootcamp ? $payment->bootcamp->title : 'Unknown');
                    $this->info("  {$payment->transaction_id} - {$course} - Rp" . number_format($payment->amount));
                }
                
                $orderId = $this->ask('Enter order ID to simulate webhook (or press Enter to use latest)');
                
                if (!$orderId) {
                    $orderId = $pendingPayments->first()->transaction_id;
                }
            } else {
                $this->error('No pending payments found to simulate');
                return Command::FAILURE;
            }
        }
        
        $payment = Payment::where('transaction_id', $orderId)->first();
        
        if (!$payment) {
            $this->error("Payment with order ID {$orderId} not found");
            return Command::FAILURE;
        }
        
        $this->info('🔔 SIMULATING WEBHOOK FOR: ' . $orderId);
        $this->info('==============================');
        
        $this->info('');
        $this->info('📊 BEFORE:');
        $this->info("  Status: {$payment->status}");
        $this->info("  Payment Date: " . ($payment->payment_date ?: 'Not set'));
        
        // Simulate successful payment webhook
        $payment->update([
            'status' => 'completed',
            'payment_date' => now(),
            'notes' => 'Payment completed successfully (simulated)'
        ]);
        
        // Trigger auto-enrollment
        $this->autoEnrollUser($payment);
        
        $payment->refresh();
        
        $this->info('');
        $this->info('📊 AFTER:');
        $this->info("  Status: {$payment->status}");
        $this->info("  Payment Date: {$payment->payment_date}");
        $this->info("  Notes: {$payment->notes}");
        
        // Check enrollment
        if ($payment->class_id) {
            $enrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                ->where('class_id', $payment->class_id)
                ->first();
            
            if ($enrollment) {
                $this->info("  Enrollment: ✅ User enrolled in class");
            } else {
                $this->warn("  Enrollment: ❌ User not enrolled");
            }
        } elseif ($payment->bootcamp_id) {
            $enrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                ->where('bootcamp_id', $payment->bootcamp_id)
                ->first();
            
            if ($enrollment) {
                $this->info("  Enrollment: ✅ User enrolled in bootcamp");
            } else {
                $this->warn("  Enrollment: ❌ User not enrolled");
            }
        }
        
        $this->info('');
        $this->info('🎉 WEBHOOK SIMULATION COMPLETE!');
        $this->info('Payment status updated to SUCCESS and user auto-enrolled.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Auto-enroll user after successful payment
     */
    private function autoEnrollUser($payment)
    {
        try {
            if (!$payment->user_id) {
                return;
            }

            if ($payment->class_id) {
                // Enroll in class
                $existingEnrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                    ->where('class_id', $payment->class_id)
                    ->where('type', 'class')
                    ->first();

                if (!$existingEnrollment) {
                    \App\Models\Enrollment::create([
                        'user_id' => $payment->user_id,
                        'class_id' => $payment->class_id,
                        'type' => 'class',
                        'status' => 'active',
                        'enrolled_at' => now(),
                        'progress' => 0.00,
                        'notes' => 'Auto-enrolled after payment completion (simulated)'
                    ]);
                }
            } elseif ($payment->bootcamp_id) {
                // Enroll in bootcamp
                $existingEnrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                    ->where('bootcamp_id', $payment->bootcamp_id)
                    ->where('type', 'bootcamp')
                    ->first();

                if (!$existingEnrollment) {
                    \App\Models\Enrollment::create([
                        'user_id' => $payment->user_id,
                        'bootcamp_id' => $payment->bootcamp_id,
                        'type' => 'bootcamp',
                        'status' => 'active',
                        'enrolled_at' => now(),
                        'progress' => 0.00,
                        'notes' => 'Auto-enrolled after payment completion (simulated)'
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->error('Auto-enrollment failed: ' . $e->getMessage());
        }
    }
}
