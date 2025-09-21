<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;

class CleanupOrphanedPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:orphaned-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup payments with missing class or bootcamp references';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Cleaning up orphaned payments...');
        
        // Find payments with invalid class_id
        $orphanedClassPayments = Payment::whereNotNull('class_id')
            ->whereDoesntHave('class')
            ->get();
            
        // Find payments with invalid bootcamp_id
        $orphanedBootcampPayments = Payment::whereNotNull('bootcamp_id')
            ->whereDoesntHave('bootcamp')
            ->get();
            
        // Find payments with no class_id and no bootcamp_id
        $noReferencePayments = Payment::whereNull('class_id')
            ->whereNull('bootcamp_id')
            ->get();
        
        $this->info("Found {$orphanedClassPayments->count()} payments with invalid class references");
        $this->info("Found {$orphanedBootcampPayments->count()} payments with invalid bootcamp references");
        $this->info("Found {$noReferencePayments->count()} payments with no course references");
        
        $totalOrphaned = $orphanedClassPayments->count() + $orphanedBootcampPayments->count() + $noReferencePayments->count();
        
        if ($totalOrphaned > 0) {
            if ($this->confirm("Do you want to delete these {$totalOrphaned} orphaned payments?")) {
                $deleted = 0;
                
                foreach ($orphanedClassPayments as $payment) {
                    $this->line("Deleting payment {$payment->id} with invalid class_id {$payment->class_id}");
                    $payment->delete();
                    $deleted++;
                }
                
                foreach ($orphanedBootcampPayments as $payment) {
                    $this->line("Deleting payment {$payment->id} with invalid bootcamp_id {$payment->bootcamp_id}");
                    $payment->delete();
                    $deleted++;
                }
                
                foreach ($noReferencePayments as $payment) {
                    $this->line("Deleting payment {$payment->id} with no course reference");
                    $payment->delete();
                    $deleted++;
                }
                
                $this->info("✅ Deleted {$deleted} orphaned payments");
            } else {
                $this->info("❌ Cleanup cancelled");
            }
        } else {
            $this->info("✅ No orphaned payments found - database is clean!");
        }
        
        // Show current payment statistics
        $totalPayments = Payment::count();
        $completedPayments = Payment::where('status', 'completed')->count();
        $validPayments = Payment::where(function($query) {
            $query->whereHas('class')->orWhereHas('bootcamp');
        })->count();
        
        $this->info('');
        $this->info('📊 Payment Statistics:');
        $this->info("Total payments: {$totalPayments}");
        $this->info("Completed payments: {$completedPayments}");
        $this->info("Valid payments (with course): {$validPayments}");
        
        return Command::SUCCESS;
    }
}
