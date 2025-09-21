<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Log;

class ProcessPendingEnrollments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enrollments:process-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending enrollments for completed payments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing pending enrollments...');

        // Get all completed payments that don't have corresponding enrollments
        $completedPayments = Payment::where('status', 'completed')
            ->whereNotNull('user_id') // Ensure user_id is not null
            ->where(function($query) {
                $query->whereNotNull('class_id')->orWhereNotNull('bootcamp_id');
            })
            ->get();

        $this->info("Found {$completedPayments->count()} completed payments");

        $processedCount = 0;
        $skippedCount = 0;

        foreach ($completedPayments as $payment) {
            try {
                $enrolled = false;

                if ($payment->class_id) {
                    // Check if enrollment already exists for class
                    $existingEnrollment = Enrollment::where('user_id', $payment->user_id)
                        ->where('class_id', $payment->class_id)
                        ->where('type', 'class')
                        ->first();

                    if (!$existingEnrollment) {
                        Enrollment::create([
                            'user_id' => $payment->user_id,
                            'class_id' => $payment->class_id,
                            'type' => 'class',
                            'status' => 'active',
                            'enrolled_at' => $payment->payment_date ?? $payment->updated_at,
                            'progress' => 0.00,
                            'notes' => 'Auto-enrolled after payment completion (batch process)'
                        ]);
                        
                        $this->info("✓ Enrolled user {$payment->user_id} in class {$payment->class_id}");
                        $enrolled = true;
                    } else {
                        $this->warn("- User {$payment->user_id} already enrolled in class {$payment->class_id}");
                        $skippedCount++;
                    }
                } elseif ($payment->bootcamp_id) {
                    // Check if enrollment already exists for bootcamp
                    $existingEnrollment = Enrollment::where('user_id', $payment->user_id)
                        ->where('bootcamp_id', $payment->bootcamp_id)
                        ->where('type', 'bootcamp')
                        ->first();

                    if (!$existingEnrollment) {
                        Enrollment::create([
                            'user_id' => $payment->user_id,
                            'bootcamp_id' => $payment->bootcamp_id,
                            'type' => 'bootcamp',
                            'status' => 'active',
                            'enrolled_at' => $payment->payment_date ?? $payment->updated_at,
                            'progress' => 0.00,
                            'notes' => 'Auto-enrolled after payment completion (batch process)'
                        ]);
                        
                        $this->info("✓ Enrolled user {$payment->user_id} in bootcamp {$payment->bootcamp_id}");
                        $enrolled = true;
                    } else {
                        $this->warn("- User {$payment->user_id} already enrolled in bootcamp {$payment->bootcamp_id}");
                        $skippedCount++;
                    }
                }

                if ($enrolled) {
                    $processedCount++;
                }

            } catch (\Exception $e) {
                $this->error("✗ Failed to enroll payment {$payment->id}: " . $e->getMessage());
                Log::error('Batch enrollment failed', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("\nProcessing completed:");
        $this->info("- Processed: {$processedCount} enrollments");
        $this->info("- Skipped: {$skippedCount} (already enrolled)");
        $this->info("- Total enrollments now: " . Enrollment::count());

        return Command::SUCCESS;
    }
}
