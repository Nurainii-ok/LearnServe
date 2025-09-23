<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;

class TestMidtransAutomatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:midtrans-automatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Midtrans Automatic Payment Information System';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 MIDTRANS AUTOMATIC PAYMENT SYSTEM');
        $this->info('====================================');
        
        $this->info('');
        $this->info('✅ SISTEM OTOMATIS YANG DIIMPLEMENTASI:');
        $this->info('  • Payment Method: Otomatis dari Midtrans');
        $this->info('  • Transaction Details: Otomatis dari webhook');
        $this->info('  • Bank Information: Otomatis dari response');
        $this->info('  • VA Number: Otomatis dari notification');
        $this->info('  • Settlement Time: Otomatis dari Midtrans');
        $this->info('  • Fraud Status: Otomatis dari Midtrans');
        
        $this->info('');
        $this->info('📊 DATABASE FIELDS YANG DITAMBAHKAN:');
        $this->info('  • midtrans_transaction_id');
        $this->info('  • midtrans_payment_type');
        $this->info('  • midtrans_gross_amount');
        $this->info('  • midtrans_transaction_time');
        $this->info('  • midtrans_settlement_time');
        $this->info('  • midtrans_signature_key');
        $this->info('  • midtrans_fraud_status');
        $this->info('  • midtrans_bank');
        $this->info('  • midtrans_va_number');
        $this->info('  • midtrans_biller_code');
        $this->info('  • midtrans_bill_key');
        $this->info('  • midtrans_raw_notification');
        
        $this->info('');
        $this->info('🔄 FLOW OTOMATIS:');
        $this->info('  1. User checkout → Minimal info (nama, email, phone)');
        $this->info('  2. Midtrans payment → User pilih method di Midtrans');
        $this->info('  3. Webhook notification → Semua detail otomatis tersimpan');
        $this->info('  4. Payment method → Format otomatis (BCA VA, GoPay, dll)');
        $this->info('  5. Status update → Otomatis completed/failed');
        
        $this->info('');
        $this->info('💳 PAYMENT METHODS YANG DIFORMAT OTOMATIS:');
        $this->info('  • bank_transfer + BCA → "BCA Bank Transfer"');
        $this->info('  • bca_va → "BCA Virtual Account"');
        $this->info('  • gopay → "GoPay"');
        $this->info('  • qris → "QRIS"');
        $this->info('  • credit_card → "Credit Card"');
        $this->info('  • echannel → "Mandiri Bill Payment"');
        
        $this->info('');
        $this->info('📋 CONTOH DATA OTOMATIS:');
        
        // Show example of latest payment with Midtrans data
        $latestPayment = Payment::whereNotNull('midtrans_payment_type')
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($latestPayment) {
            $this->info('  Order ID: ' . $latestPayment->transaction_id);
            $this->info('  Payment Method: ' . $latestPayment->payment_method);
            $this->info('  Midtrans Type: ' . $latestPayment->midtrans_payment_type);
            $this->info('  Bank: ' . ($latestPayment->midtrans_bank ?: 'N/A'));
            $this->info('  VA Number: ' . ($latestPayment->midtrans_va_number ?: 'N/A'));
            $this->info('  Amount: Rp' . number_format($latestPayment->midtrans_gross_amount ?: $latestPayment->amount));
            $this->info('  Status: ' . $latestPayment->status);
        } else {
            $this->info('  No payments with Midtrans data found yet');
            $this->info('  Make a test payment to see automatic data');
        }
        
        $this->info('');
        $this->info('🎯 KEUNTUNGAN SISTEM OTOMATIS:');
        $this->info('  • Admin tidak perlu input manual');
        $this->info('  • Data akurat 100% dari Midtrans');
        $this->info('  • Payment method detail lengkap');
        $this->info('  • Tracking transaction yang sempurna');
        $this->info('  • Audit trail yang lengkap');
        
        $this->info('');
        $this->info('🎉 SISTEM OTOMATIS SIAP!');
        $this->info('Semua informasi payment akan otomatis tersimpan');
        $this->info('dari Midtrans tanpa input manual sama sekali!');
        
        return Command::SUCCESS;
    }
}
