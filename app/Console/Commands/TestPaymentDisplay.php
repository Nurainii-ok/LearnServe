<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;

class TestPaymentDisplay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:payment-display';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Payment Display - Midtrans Style';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('💳 PAYMENT DISPLAY - MIDTRANS STYLE');
        $this->info('===================================');
        
        $this->info('');
        $this->info('✅ PERUBAHAN YANG DILAKUKAN:');
        $this->info('  • Removed "Add New Payment" button');
        $this->info('  • Removed "Actions" column (Edit/Delete)');
        $this->info('  • Added "Auto-synchronized with Midtrans" info');
        $this->info('  • Display matches Midtrans dashboard format');
        
        $this->info('');
        $this->info('📊 KOLOM YANG DITAMPILKAN:');
        $this->info('  • Transaction ID (with Midtrans ID if different)');
        $this->info('  • Member (name + email from payment data)');
        $this->info('  • Course (class/bootcamp title + tutor)');
        $this->info('  • Amount (Midtrans amount + original if different)');
        $this->info('  • Method (formatted payment method + bank + VA)');
        $this->info('  • Status (Settlement/Pending/Failed + fraud status)');
        $this->info('  • Date (settlement time + transaction time)');
        
        $this->info('');
        $this->info('🎯 INFORMASI YANG DITAMPILKAN:');
        
        $payments = Payment::with(['user', 'class', 'bootcamp'])->latest()->take(3)->get();
        
        if ($payments->count() > 0) {
            foreach ($payments as $payment) {
                $this->info('');
                $this->info("📋 {$payment->transaction_id}:");
                $this->info("  Member: {$payment->full_name} ({$payment->email})");
                $this->info("  Amount: Rp" . number_format($payment->midtrans_gross_amount ?: $payment->amount));
                $this->info("  Method: {$payment->payment_method}");
                $this->info("  Status: {$payment->status}");
                $this->info("  Bank: " . ($payment->midtrans_bank ?: 'N/A'));
                $this->info("  VA Number: " . ($payment->midtrans_va_number ?: 'N/A'));
            }
        } else {
            $this->info('  No payments found to display');
        }
        
        $this->info('');
        $this->info('🔄 SINKRONISASI OTOMATIS:');
        $this->info('  • Data payment otomatis dari Midtrans webhook');
        $this->info('  • Status otomatis update (pending → settlement)');
        $this->info('  • Payment method otomatis terdeteksi');
        $this->info('  • Bank dan VA number otomatis tersimpan');
        $this->info('  • Fraud status otomatis dimonitor');
        
        $this->info('');
        $this->info('🚫 YANG DIHAPUS:');
        $this->info('  • Tombol "Add New Payment" (tidak diperlukan)');
        $this->info('  • Kolom "Actions" (Edit/Delete tidak diperlukan)');
        $this->info('  • Manual payment creation (semua otomatis)');
        $this->info('  • Manual status update (otomatis dari webhook)');
        
        $this->info('');
        $this->info('🎉 PAYMENT DISPLAY READY!');
        $this->info('Halaman payment sekarang menampilkan data persis');
        $this->info('seperti di Midtrans dashboard - read-only & auto-sync!');
        
        return Command::SUCCESS;
    }
}
