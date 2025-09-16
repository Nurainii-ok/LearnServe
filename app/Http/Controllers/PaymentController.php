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
                'class_id' => 'required|exists:classes,id',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'amount' => 'required|numeric|min:0'
            ]);

            $class = Classes::findOrFail($request->class_id);
            $orderId = 'ORDER-' . time() . '-' . Str::random(5);
            
            Log::info('Creating payment for order: ' . $orderId);

            // Create payment record
            $payment = Payment::create([
                'user_id' => session('user_id'),
                'class_id' => $request->class_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'amount' => $request->amount,
                'payment_method' => 'midtrans',
                'transaction_id' => $orderId,
                'status' => 'pending',
                'notes' => 'Payment via Midtrans'
            ]);

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
                'id' => 'class_' . $class->id,
                'price' => (int) $request->amount,
                'quantity' => 1,
                'name' => substr($class->title, 0, 50), // Limit to 50 characters
                'brand' => 'LearnServe',
                'category' => 'Course',
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

        } catch (\Exception $e) {
            Log::error('Payment creation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // More specific error handling
            $errorMessage = 'Failed to create payment';
            if (strpos($e->getMessage(), 'CURL') !== false) {
                $errorMessage = 'Network connection error. Please check your internet connection.';
            } elseif (strpos($e->getMessage(), 'SSL') !== false) {
                $errorMessage = 'SSL connection error. Please try again.';
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

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;

            // Find payment record
            $payment = Payment::where('transaction_id', $orderId)->first();

            if (!$payment) {
                Log::error('Payment not found for order ID: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
            }

            // Update payment status based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $payment->update([
                        'status' => 'pending',
                        'notes' => 'Transaction is challenged by FDS'
                    ]);
                } else if ($fraudStatus == 'accept') {
                    $payment->update([
                        'status' => 'completed',
                        'payment_date' => now(),
                        'notes' => 'Payment completed successfully'
                    ]);
                }
            } else if ($transactionStatus == 'settlement') {
                $payment->update([
                    'status' => 'completed',
                    'payment_date' => now(),
                    'notes' => 'Payment completed successfully'
                ]);
            } else if ($transactionStatus == 'pending') {
                $payment->update([
                    'status' => 'pending',
                    'notes' => 'Waiting for payment'
                ]);
            } else if ($transactionStatus == 'deny') {
                $payment->update([
                    'status' => 'failed',
                    'notes' => 'Payment denied'
                ]);
            } else if ($transactionStatus == 'expire') {
                $payment->update([
                    'status' => 'failed',
                    'notes' => 'Payment expired'
                ]);
            } else if ($transactionStatus == 'cancel') {
                $payment->update([
                    'status' => 'failed',
                    'notes' => 'Payment cancelled'
                ]);
            }

            Log::info('Payment notification processed for order: ' . $orderId . ' with status: ' . $transactionStatus);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Payment notification error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
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
        $payment = Payment::where('transaction_id', $orderId)->with('class')->first();

        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found');
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
     * Check payment status
     */
    public function checkStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            $payment = Payment::where('transaction_id', $orderId)->first();

            return response()->json([
                'success' => true,
                'midtrans_status' => $status,
                'payment_status' => $payment ? $payment->status : 'not_found'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
}
