<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Classes;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
        
        // Comprehensive SSL fix for development environment
        if (config('services.midtrans.disable_ssl_verify', true)) {
            // Set global CURL options
            $this->setCurlDefaults();
            
            // Set default stream context options
            stream_context_set_default([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                    'verify_depth' => 0
                ],
                'http' => [
                    'timeout' => 120,
                    'method' => 'POST',
                    'header' => [
                        'User-Agent: Laravel/LearnServe',
                        'Accept: application/json',
                        'Content-Type: application/json'
                    ]
                ]
            ]);
            
            // Override Midtrans CURL options
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 120,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 3,
                CURLOPT_USERAGENT => 'Laravel/LearnServe Midtrans-PHP',
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ]
            ];
        }
    }
    
    /**
     * Set default CURL options globally
     */
    private function setCurlDefaults()
    {
        // Set default CURL options for the entire application
        if (function_exists('curl_setopt_array')) {
            $defaultOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 120,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_USERAGENT => 'Laravel/LearnServe',
                CURLOPT_FOLLOWLOCATION => true
            ];
            
            // Store for later use in requests
            Config::$curlOptions = $defaultOptions;
        }
    }

    /**
     * Create payment transaction
     */
    public function createTransaction(Request $request)
    {
        try {
            // Log incoming request for debugging
            Log::info('Payment request received', $request->all());
            
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'amount' => 'required|numeric|min:0'
            ]);

            // Validate that either class_id or bootcamp_id is provided
            if (!$request->has('class_id') && !$request->has('bootcamp_id')) {
                Log::error('Neither class_id nor bootcamp_id provided');
                throw new \Exception('Either class_id or bootcamp_id must be provided');
            }

            $class = null;
            $bootcamp = null;
            $itemName = '';
            
            if ($request->filled('class_id')) {
                Log::info('Processing class payment', ['class_id' => $request->class_id]);
                $class = Classes::find($request->class_id);
                if (!$class) {
                    throw new \Exception('Class not found with ID: ' . $request->class_id);
                }
                $itemName = $class->title;
                Log::info('Class found', ['title' => $itemName, 'price' => $class->price]);
            } elseif ($request->filled('bootcamp_id')) {
                Log::info('Processing bootcamp payment', ['bootcamp_id' => $request->bootcamp_id]);
                $bootcamp = \App\Models\Bootcamp::find($request->bootcamp_id);
                if (!$bootcamp) {
                    throw new \Exception('Bootcamp not found with ID: ' . $request->bootcamp_id);
                }
                $itemName = $bootcamp->title;
                Log::info('Bootcamp found', ['title' => $itemName, 'price' => $bootcamp->price]);
            } else {
                Log::error('No valid class_id or bootcamp_id provided', $request->all());
                throw new \Exception('Either class_id or bootcamp_id must be provided');
            }
            
            $orderId = 'ORDER-' . time() . '-' . Str::random(5);
            
            Log::info('Creating payment for order: ' . $orderId);

            // Create payment record
            $paymentData = [
                'user_id' => session('user_id'),
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'amount' => $request->amount,
                'payment_method' => 'midtrans',
                'transaction_id' => $orderId,
                'status' => 'pending'
            ];
            
            if ($class) {
                $paymentData['class_id'] = $class->id;
                $paymentData['notes'] = 'Payment for class: ' . $class->title;
            } elseif ($bootcamp) {
                $paymentData['bootcamp_id'] = $bootcamp->id;
                $paymentData['notes'] = 'Payment for bootcamp: ' . $bootcamp->title;
            }
            
            Log::info('Creating payment record', $paymentData);
            $payment = Payment::create($paymentData);

            // Prepare transaction details for Midtrans
            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->amount
            ];

            // Format phone number (add +62 if not present)
            $phone = $request->phone;
            if (!str_starts_with($phone, '+')) {
                if (str_starts_with($phone, '0')) {
                    $phone = '+62' . substr($phone, 1);
                } elseif (str_starts_with($phone, '62')) {
                    $phone = '+' . $phone;
                } else {
                    $phone = '+62' . $phone;
                }
            }

            $customerDetails = [
                'first_name' => $request->full_name,
                'last_name' => '',
                'email' => $request->email,
                'phone' => $phone,
                'billing_address' => [
                    'first_name' => $request->full_name,
                    'last_name' => '',
                    'email' => $request->email,
                    'phone' => $phone,
                    'address' => 'Jakarta',
                    'city' => 'Jakarta',
                    'postal_code' => '12345',
                    'country_code' => 'IDN'
                ],
                'shipping_address' => [
                    'first_name' => $request->full_name,
                    'last_name' => '',
                    'email' => $request->email,
                    'phone' => $phone,
                    'address' => 'Jakarta',
                    'city' => 'Jakarta',
                    'postal_code' => '12345',
                    'country_code' => 'IDN'
                ]
            ];

            $itemDetails = [[
                'id' => $class ? 'class_' . $class->id : 'bootcamp_' . $bootcamp->id,
                'price' => (int) $request->amount,
                'quantity' => 1,
                'name' => substr($itemName, 0, 50), // Limit to 50 characters
                'brand' => 'LearnServe',
                'category' => $class ? 'Course' : 'Bootcamp',
                'merchant_name' => 'LearnServe'
            ]];

            $transactionData = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
                'enabled_payments' => [
                    'credit_card', 'gopay', 'bank_transfer', 'echannel', 
                    'bca_va', 'bni_va', 'bri_va', 'other_va', 'qris'
                ],
                'credit_card' => [
                    'secure' => true
                ],
                'expiry' => [
                    'start_time' => date('Y-m-d H:i:s O'),
                    'unit' => 'minutes',
                    'duration' => 60
                ]
            ];
            
            Log::info('Transaction data prepared', $transactionData);

            // Get Snap Token with enhanced error handling
            try {
                // Additional SSL bypass for this specific request
                if (config('services.midtrans.disable_ssl_verify', true)) {
                    // Set additional environment for this request
                    putenv('CURL_CA_BUNDLE=');
                    putenv('SSL_CERT_FILE=');
                }
                
                $snapToken = Snap::getSnapToken($transactionData);
                
                Log::info('Snap token created successfully', ['order_id' => $orderId, 'snap_token' => $snapToken]);
                
            } catch (\Exception $snapError) {
                Log::error('Snap token creation failed: ' . $snapError->getMessage());
                
                // Try alternative approach with manual CURL bypass
                if (strpos($snapError->getMessage(), 'SSL') !== false || strpos($snapError->getMessage(), 'CURL') !== false) {
                    // Force disable SSL for this request
                    $oldCurlOptions = Config::$curlOptions ?? [];
                    Config::$curlOptions = array_merge($oldCurlOptions, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                        CURLOPT_CAINFO => null,
                        CURLOPT_CAPATH => null
                    ]);
                    
                    try {
                        $snapToken = Snap::getSnapToken($transactionData);
                    } catch (\Exception $retryError) {
                        throw new \Exception('SSL connection failed: ' . $retryError->getMessage());
                    }
                } else {
                    throw $snapError;
                }
            }
            
            // Update payment with snap token
            $payment->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in payment creation', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors())),
                'debug' => config('app.debug') ? $e->errors() : null
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment creation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // More specific error handling
            $errorMessage = 'Failed to create payment';
            if (strpos($e->getMessage(), 'CURL') !== false) {
                $errorMessage = 'Network connection error. Please check your internet connection.';
            } elseif (strpos($e->getMessage(), 'SSL') !== false) {
                $errorMessage = 'SSL connection error. Please try again.';
            } elseif (strpos($e->getMessage(), 'not found') !== false) {
                $errorMessage = $e->getMessage();
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification callback
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            // Get all transaction details from Midtrans
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;
            $paymentType = $notification->payment_type;
            $grossAmount = $notification->gross_amount;
            $transactionTime = $notification->transaction_time;
            $settlementTime = $notification->settlement_time ?? null;
            $signatureKey = $notification->signature_key;
            
            // Get additional payment method details
            $bankName = $notification->va_numbers[0]->bank ?? $notification->bank ?? null;
            $vaNumber = $notification->va_numbers[0]->va_number ?? $notification->account_number ?? null;
            $billerCode = $notification->biller_code ?? null;
            $billKey = $notification->bill_key ?? null;

            Log::info('Payment notification received with full details', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
                'gross_amount' => $grossAmount,
                'transaction_time' => $transactionTime,
                'settlement_time' => $settlementTime,
                'bank_name' => $bankName,
                'va_number' => $vaNumber
            ]);

            // Find payment record
            $payment = Payment::where('transaction_id', $orderId)->first();

            if (!$payment) {
                Log::error('Payment not found for order ID: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
            }

            // Only process if status is changing to avoid duplicate processing
            $oldStatus = $payment->status;

            // Prepare update data with Midtrans information
            $updateData = [
                'payment_method' => $this->formatPaymentMethod($paymentType, $bankName),
                'midtrans_transaction_id' => $notification->transaction_id ?? null,
                'midtrans_payment_type' => $paymentType,
                'midtrans_gross_amount' => $grossAmount,
                'midtrans_transaction_time' => $transactionTime,
                'midtrans_settlement_time' => $settlementTime,
                'midtrans_signature_key' => $signatureKey,
                'midtrans_fraud_status' => $fraudStatus,
                'midtrans_bank' => $bankName,
                'midtrans_va_number' => $vaNumber,
                'midtrans_biller_code' => $billerCode,
                'midtrans_bill_key' => $billKey,
                'midtrans_raw_notification' => json_encode($notification->getResponse())
            ];

            // Update payment status based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $updateData['status'] = 'pending';
                    $updateData['notes'] = 'Transaction is challenged by FDS - ' . $paymentType;
                } else if ($fraudStatus == 'accept') {
                    $updateData['status'] = 'completed';
                    $updateData['payment_date'] = $settlementTime ? date('Y-m-d H:i:s', strtotime($settlementTime)) : now();
                    $updateData['notes'] = 'Payment completed via ' . $this->formatPaymentMethod($paymentType, $bankName);
                    
                    // Auto-enroll user after successful payment (only if status changed)
                    if ($oldStatus !== 'completed') {
                        $this->autoEnrollUser($payment);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $updateData['status'] = 'completed';
                $updateData['payment_date'] = $settlementTime ? date('Y-m-d H:i:s', strtotime($settlementTime)) : now();
                $updateData['notes'] = 'Payment settled via ' . $this->formatPaymentMethod($paymentType, $bankName);
                
                // Auto-enroll user after successful payment (only if status changed)
                if ($oldStatus !== 'completed') {
                    $this->autoEnrollUser($payment);
                }
            } else if ($transactionStatus == 'pending') {
                $updateData['status'] = 'pending';
                $updateData['notes'] = 'Waiting for payment via ' . $this->formatPaymentMethod($paymentType, $bankName);
                
                // Add payment instructions for pending payments
                if ($vaNumber) {
                    $updateData['notes'] .= ' - VA Number: ' . $vaNumber;
                }
                if ($billerCode && $billKey) {
                    $updateData['notes'] .= ' - Biller Code: ' . $billerCode . ', Bill Key: ' . $billKey;
                }
            } else if ($transactionStatus == 'deny') {
                $updateData['status'] = 'failed';
                $updateData['notes'] = 'Payment denied via ' . $this->formatPaymentMethod($paymentType, $bankName);
            } else if ($transactionStatus == 'expire') {
                $updateData['status'] = 'failed';
                $updateData['notes'] = 'Payment expired via ' . $this->formatPaymentMethod($paymentType, $bankName);
            } else if ($transactionStatus == 'cancel') {
                $updateData['status'] = 'failed';
                $updateData['notes'] = 'Payment cancelled via ' . $this->formatPaymentMethod($paymentType, $bankName);
            }

            // Update payment with all Midtrans data
            $payment->update($updateData);

            Log::info('Payment notification processed with full Midtrans data', [
                'order_id' => $orderId,
                'status' => $updateData['status'],
                'payment_method' => $updateData['payment_method'],
                'amount' => $grossAmount
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Payment notification error: ' . $e->getMessage());
            Log::error('Notification data: ' . json_encode($request->all()));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
        
    }
    
    /**
     * Format payment method name from Midtrans data
     */
    private function formatPaymentMethod($paymentType, $bankName = null)
    {
        $methods = [
            'credit_card' => 'Credit Card',
            'bank_transfer' => $bankName ? strtoupper($bankName) . ' Bank Transfer' : 'Bank Transfer',
            'echannel' => 'Mandiri Bill Payment',
            'gopay' => 'GoPay',
            'shopeepay' => 'ShopeePay',
            'qris' => 'QRIS',
            'cstore' => 'Convenience Store',
            'akulaku' => 'Akulaku',
            'bca_va' => 'BCA Virtual Account',
            'bni_va' => 'BNI Virtual Account',
            'bri_va' => 'BRI Virtual Account',
            'other_va' => ($bankName ? strtoupper($bankName) : 'Other') . ' Virtual Account'
        ];
        
        return $methods[$paymentType] ?? ucwords(str_replace('_', ' ', $paymentType));
    }

    /**
     * Handle payment finish redirect
     */
    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        $payment = Payment::where('transaction_id', $orderId)->first();

        if ($payment) {
            return redirect()->route('payment.success', ['order_id' => $orderId])
                ->with('payment', $payment);
        }

        return redirect()->route('payment.failed')
            ->with('error', 'Payment not found');
    }

    /**
     * Show payment success page
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $payment = Payment::where('transaction_id', $orderId)
            ->with(['class', 'bootcamp'])
            ->first();

        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found');
        }

        try {
            // Ambil status terbaru dari Midtrans (biar nggak hanya bergantung DB)
            $midtransStatus = Transaction::status($orderId);

            // Sync ke DB
            $this->syncPaymentStatus($payment, $midtransStatus);

            // Pastikan enrollment dibuat kalau pembayaran sukses/settlement
            if (in_array($payment->status, ['success', 'settlement', 'completed'])) {
                $this->autoEnrollUser($payment);

                // Refresh relationship biar data terbaru
                $payment->refresh()->load(['class', 'bootcamp']);
            }

        } catch (\Exception $e) {
            Log::error('Payment success sync failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
        }

        return view('pages.payment_success', compact('payment'));
    }

    /**
     * Show payment failed page
     */
    public function paymentFailed()
    {
        return view('pages.payment_failed');
    }

    /**
     * Check payment status from Midtrans and sync if needed
     */
    public function checkStatus($orderId)
    {
        try {
            $payment = Payment::where('transaction_id', $orderId)->first();
            
            if (!$payment) {
                return response()->json(['error' => 'Payment not found'], 404);
            }
            
            // Get status from Midtrans
            $status = Transaction::status($orderId);
            
            Log::info('Checking payment status', [
                'order_id' => $orderId,
                'local_status' => $payment->status,
                'midtrans_status' => $status->transaction_status
            ]);
            
            // If status differs, sync it
            if ($this->shouldSyncStatus($payment->status, $status->transaction_status)) {
                $this->syncPaymentStatus($payment, $status);
                
                // Reload payment to get updated status
                $payment->refresh();
                
                Log::info('Payment status synced', [
                    'order_id' => $orderId,
                    'old_status' => $payment->status,
                    'new_status' => $status->transaction_status
                ]);
            }
            
            return response()->json([
                'order_id' => $orderId,
                'local_status' => $payment->status,
                'midtrans_status' => $status->transaction_status,
                'payment_type' => $status->payment_type ?? null,
                'gross_amount' => $status->gross_amount ?? null,
                'synced' => $this->shouldSyncStatus($payment->status, $status->transaction_status)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error checking payment status: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Manual sync payment status from Midtrans
     */
    public function syncStatus($orderId)
    {
        try {
            $payment = Payment::where('transaction_id', $orderId)->first();
            
            if (!$payment) {
                return response()->json(['error' => 'Payment not found'], 404);
            }
            
            // Get status from Midtrans
            $status = Transaction::status($orderId);
            
            Log::info('Manual sync payment status', [
                'order_id' => $orderId,
                'old_status' => $payment->status,
                'midtrans_status' => $status->transaction_status
            ]);
            
            $oldStatus = $payment->status;
            $this->syncPaymentStatus($payment, $status);
            
            // Reload payment to get updated status
            $payment->refresh();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment status synced successfully',
                'order_id' => $orderId,
                'old_status' => $oldStatus,
                'new_status' => $payment->status,
                'midtrans_data' => [
                    'transaction_status' => $status->transaction_status,
                    'payment_type' => $status->payment_type ?? null,
                    'gross_amount' => $status->gross_amount ?? null,
                    'settlement_time' => $status->settlement_time ?? null
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error syncing payment status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Check if status should be synced
     */
    private function shouldSyncStatus($localStatus, $midtransStatus)
    {
        // Always sync if local is pending but midtrans is settled/completed
        if ($localStatus === 'pending' && in_array($midtransStatus, ['settlement', 'capture'])) {
            return true;
        }
        
        // Sync if local is not failed but midtrans shows failure
        if (!in_array($localStatus, ['failed', 'cancelled']) && in_array($midtransStatus, ['deny', 'expire', 'cancel'])) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Sync payment status with Midtrans data
     */
    private function syncPaymentStatus($payment, $midtransResponse)
    {
        $transactionStatus = $midtransResponse->transaction_status;
        $fraudStatus = $midtransResponse->fraud_status ?? 'accept';

        $updateData = [
            'midtrans_transaction_id' => $midtransResponse->transaction_id ?? null,
            'midtrans_payment_type' => $midtransResponse->payment_type ?? null,
            'midtrans_gross_amount' => $midtransResponse->gross_amount ?? null,
            'midtrans_transaction_time' => $midtransResponse->transaction_time ?? null,
            'midtrans_settlement_time' => $midtransResponse->settlement_time ?? null,
            'midtrans_fraud_status' => $fraudStatus,
            'midtrans_signature_key' => $midtransResponse->signature_key ?? null,
        ];

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $updateData['status'] = 'pending';
                $updateData['notes'] = 'Transaction is challenged by FDS';
            } else {
                $updateData['status'] = 'completed';
                $updateData['payment_date'] = $midtransResponse->settlement_time
                    ? date('Y-m-d H:i:s', strtotime($midtransResponse->settlement_time))
                    : now();
                $updateData['notes'] = 'Payment completed - synced from Midtrans';

                if ($payment->status !== 'completed') {
                    $this->autoEnrollUser($payment);
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $updateData['status'] = 'completed';
            $updateData['payment_date'] = $midtransResponse->settlement_time
                ? date('Y-m-d H:i:s', strtotime($midtransResponse->settlement_time))
                : now();
            $updateData['notes'] = 'Payment settled - synced from Midtrans';

            if ($payment->status !== 'completed') {
                $this->autoEnrollUser($payment);
            }
        } elseif ($transactionStatus == 'pending') {
            $updateData['status'] = 'pending';
            $updateData['notes'] = 'Waiting for payment - synced from Midtrans';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $updateData['status'] = 'failed';
            $updateData['notes'] = 'Payment ' . $transactionStatus . ' - synced from Midtrans';
        }

        $payment->update($updateData);

        Log::info('Payment synced successfully', [
            'order_id' => $payment->transaction_id,
            'new_status' => $updateData['status'],
            'midtrans_status' => $transactionStatus
        ]);
    }


    /**
     * Test webhook notification manually
     */
    public function testWebhook(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            
            if (!$orderId) {
                return response()->json(['error' => 'Order ID is required'], 400);
            }
            
            // Get payment record
            $payment = Payment::where('transaction_id', $orderId)->first();
            
            if (!$payment) {
                return response()->json(['error' => 'Payment not found'], 404);
            }
            
            // Get status from Midtrans
            $status = Transaction::status($orderId);
            
            // Simulate webhook notification
            $webhookData = [
                'transaction_status' => $status->transaction_status,
                'order_id' => $orderId,
                'gross_amount' => $status->gross_amount,
                'payment_type' => $status->payment_type,
                'transaction_time' => $status->transaction_time,
                'settlement_time' => $status->settlement_time ?? null,
                'fraud_status' => $status->fraud_status ?? 'accept',
                'signature_key' => $status->signature_key ?? null
            ];
            
            Log::info('Manual webhook test', $webhookData);
            
            // Process the webhook data
            $request->merge($webhookData);
            $result = $this->handleNotification($request);
            
            return response()->json([
                'success' => true,
                'message' => 'Webhook test completed',
                'midtrans_data' => $webhookData,
                'webhook_result' => $result->getData()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Webhook test error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Midtrans connection
     */
    public function testMidtrans()
    {
        try {
            // Simple test transaction with proper format
            $testData = [
                'transaction_details' => [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 10000
                ],
                'customer_details' => [
                    'first_name' => 'Test User',
                    'last_name' => '',
                    'email' => 'test@learnserve.com',
                    'phone' => '+6281234567890',
                    'billing_address' => [
                        'first_name' => 'Test User',
                        'last_name' => '',
                        'email' => 'test@learnserve.com',
                        'phone' => '+6281234567890',
                        'address' => 'Jakarta',
                        'city' => 'Jakarta',
                        'postal_code' => '12345',
                        'country_code' => 'IDN'
                    ],
                    'shipping_address' => [
                        'first_name' => 'Test User',
                        'last_name' => '',
                        'email' => 'test@learnserve.com',
                        'phone' => '+6281234567890',
                        'address' => 'Jakarta',
                        'city' => 'Jakarta',
                        'postal_code' => '12345',
                        'country_code' => 'IDN'
                    ]
                ],
                'item_details' => [[
                    'id' => 'test_item_1',
                    'price' => 10000,
                    'quantity' => 1,
                    'name' => 'Test Course',
                    'brand' => 'LearnServe',
                    'category' => 'Course',
                    'merchant_name' => 'LearnServe'
                ]],
                'enabled_payments' => [
                    'credit_card', 'gopay', 'bank_transfer', 'echannel', 
                    'bca_va', 'bni_va', 'bri_va', 'other_va', 'qris'
                ],
                'credit_card' => [
                    'secure' => true
                ]
            ];

            $snapToken = Snap::getSnapToken($testData);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Midtrans connection successful',
                'snap_token' => $snapToken,
                'test_data' => $testData
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ]);
        }
    }
    
    /**
     * Auto-enroll user after successful payment
     */
    private function autoEnrollUser($payment)
    {
        try {
            Log::info('Starting auto-enrollment process', [
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'class_id' => $payment->class_id,
                'bootcamp_id' => $payment->bootcamp_id
            ]);

            if (!$payment->user_id) {
                Log::warning('Cannot auto-enroll: No user_id in payment', ['payment_id' => $payment->id]);
                return;
            }

            if ($payment->class_id) {
                // Enroll in class
                $existingEnrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                    ->where('class_id', $payment->class_id)
                    ->where('type', 'class')
                    ->first();

                if (!$existingEnrollment) {
                    $enrollment = \App\Models\Enrollment::create([
                        'user_id' => $payment->user_id,
                        'class_id' => $payment->class_id,
                        'type' => 'class',
                        'status' => 'active',
                        'enrolled_at' => now(),
                        'progress' => 0.00,
                        'notes' => 'Auto-enrolled after payment completion'
                    ]);
                    
                    Log::info('User auto-enrolled in class successfully', [
                        'user_id' => $payment->user_id,
                        'class_id' => $payment->class_id,
                        'payment_id' => $payment->id,
                        'enrollment_id' => $enrollment->id
                    ]);
                } else {
                    Log::info('User already enrolled in class', [
                        'user_id' => $payment->user_id,
                        'class_id' => $payment->class_id,
                        'existing_enrollment_id' => $existingEnrollment->id
                    ]);
                }
            } elseif ($payment->bootcamp_id) {
                // Enroll in bootcamp
                $existingEnrollment = \App\Models\Enrollment::where('user_id', $payment->user_id)
                    ->where('bootcamp_id', $payment->bootcamp_id)
                    ->where('type', 'bootcamp')
                    ->first();

                if (!$existingEnrollment) {
                    $enrollment = \App\Models\Enrollment::create([
                        'user_id' => $payment->user_id,
                        'bootcamp_id' => $payment->bootcamp_id,
                        'type' => 'bootcamp',
                        'status' => 'active',
                        'enrolled_at' => now(),
                        'progress' => 0.00,
                        'notes' => 'Auto-enrolled after payment completion'
                    ]);
                    
                    Log::info('User auto-enrolled in bootcamp successfully', [
                        'user_id' => $payment->user_id,
                        'bootcamp_id' => $payment->bootcamp_id,
                        'payment_id' => $payment->id,
                        'enrollment_id' => $enrollment->id
                    ]);
                } else {
                    Log::info('User already enrolled in bootcamp', [
                        'user_id' => $payment->user_id,
                        'bootcamp_id' => $payment->bootcamp_id,
                        'existing_enrollment_id' => $existingEnrollment->id
                    ]);
                }
            } else {
                Log::warning('No class_id or bootcamp_id found in payment', ['payment_id' => $payment->id]);
            }
        } catch (\Exception $e) {
            Log::error('Auto-enrollment failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
