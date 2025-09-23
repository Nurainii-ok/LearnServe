<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupMidtransWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:midtrans-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Guide for Midtrans Webhook Configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 MIDTRANS WEBHOOK SETUP GUIDE');
        $this->info('===============================');
        
        $webhookUrl = url('/payment/notification');
        
        $this->info('');
        $this->info('📋 STEP-BY-STEP SETUP:');
        $this->info('');
        
        $this->info('1️⃣ LOGIN TO MIDTRANS DASHBOARD');
        $this->info('   • Go to: https://dashboard.midtrans.com/');
        $this->info('   • Login with your Midtrans account');
        
        $this->info('');
        $this->info('2️⃣ NAVIGATE TO SETTINGS');
        $this->info('   • Click "Settings" in the left sidebar');
        $this->info('   • Select "Configuration"');
        
        $this->info('');
        $this->info('3️⃣ SET NOTIFICATION URL');
        $this->info('   • Find "Payment Notification URL" section');
        $this->info('   • Enter: ' . $webhookUrl);
        $this->info('   • Make sure "Enable HTTP notification" is checked');
        
        $this->info('');
        $this->info('4️⃣ CONFIGURE FINISH REDIRECT');
        $this->info('   • Finish Redirect URL: ' . url('/payment/finish'));
        $this->info('   • Unfinish Redirect URL: ' . url('/payment/failed'));
        $this->info('   • Error Redirect URL: ' . url('/payment/failed'));
        
        $this->info('');
        $this->info('5️⃣ SAVE CONFIGURATION');
        $this->info('   • Click "Update Settings" or "Save"');
        $this->info('   • Verify the settings are saved');
        
        $this->info('');
        $this->info('🌐 WEBHOOK ENDPOINTS:');
        $this->info('   • Notification: ' . $webhookUrl);
        $this->info('   • Finish: ' . url('/payment/finish'));
        $this->info('   • Success: ' . url('/payment/success'));
        $this->info('   • Failed: ' . url('/payment/failed'));
        
        $this->info('');
        $this->info('🔍 VERIFICATION:');
        $this->info('   • Make a test payment');
        $this->info('   • Check Laravel logs for webhook calls');
        $this->info('   • Verify payment status updates automatically');
        $this->info('   • Confirm user gets auto-enrolled');
        
        $this->info('');
        $this->info('⚠️ IMPORTANT NOTES:');
        $this->info('   • Webhook URL must be accessible from internet');
        $this->info('   • Use ngrok for local development testing');
        $this->info('   • CSRF protection is disabled for webhook route');
        $this->info('   • All webhook calls are logged for debugging');
        
        $this->info('');
        $this->info('🧪 FOR LOCAL TESTING:');
        $this->info('   • Install ngrok: https://ngrok.com/');
        $this->info('   • Run: ngrok http 80');
        $this->info('   • Use ngrok URL for webhook in Midtrans');
        $this->info('   • Example: https://abc123.ngrok.io/payment/notification');
        
        $this->info('');
        $this->info('🎉 SETUP COMPLETE!');
        $this->info('Once configured, payment status will automatically');
        $this->info('update from "pending" to "completed" when user pays.');
        
        return Command::SUCCESS;
    }
}
