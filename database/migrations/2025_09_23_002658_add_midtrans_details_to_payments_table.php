<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Midtrans transaction details
            $table->string('midtrans_transaction_id')->nullable()->after('transaction_id');
            $table->string('midtrans_payment_type')->nullable()->after('midtrans_transaction_id');
            $table->decimal('midtrans_gross_amount', 15, 2)->nullable()->after('midtrans_payment_type');
            $table->timestamp('midtrans_transaction_time')->nullable()->after('midtrans_gross_amount');
            $table->timestamp('midtrans_settlement_time')->nullable()->after('midtrans_transaction_time');
            $table->string('midtrans_signature_key')->nullable()->after('midtrans_settlement_time');
            $table->string('midtrans_fraud_status')->nullable()->after('midtrans_signature_key');
            
            // Payment method specific details
            $table->string('midtrans_bank')->nullable()->after('midtrans_fraud_status');
            $table->string('midtrans_va_number')->nullable()->after('midtrans_bank');
            $table->string('midtrans_biller_code')->nullable()->after('midtrans_va_number');
            $table->string('midtrans_bill_key')->nullable()->after('midtrans_biller_code');
            
            // Raw notification data for debugging
            $table->longText('midtrans_raw_notification')->nullable()->after('midtrans_bill_key');
            
            // Index for faster queries
            $table->index('midtrans_transaction_id');
            $table->index('midtrans_payment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['midtrans_transaction_id']);
            $table->dropIndex(['midtrans_payment_type']);
            
            $table->dropColumn([
                'midtrans_transaction_id',
                'midtrans_payment_type',
                'midtrans_gross_amount',
                'midtrans_transaction_time',
                'midtrans_settlement_time',
                'midtrans_signature_key',
                'midtrans_fraud_status',
                'midtrans_bank',
                'midtrans_va_number',
                'midtrans_biller_code',
                'midtrans_bill_key',
                'midtrans_raw_notification'
            ]);
        });
    }
};
