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
                'message' => 'Validation failed: ' . implode(', ', array_flatten($e->errors())),
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

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;

            Log::info('Payment notification received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            // Find payment record
            $payment = Payment::where('transaction_id', $orderId)->first();

            if (!$payment) {
                Log::error('Payment not found for order ID: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
            }

            // Only process if status is changing to avoid duplicate processing
            $oldStatus = $payment->status;

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
                    
                    // Auto-enroll user after successful payment (only if status changed)
                    if ($oldStatus !== 'completed') {
                        $this->autoEnrollUser($payment);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $payment->update([
                    'status' => 'completed',
                    'payment_date' => now(),
                    'notes' => 'Payment completed successfully'
                ]);
                
                // Auto-enroll user after successful payment (only if status changed)
                if ($oldStatus !== 'completed') {
                    $this->autoEnrollUser($payment);
                }
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
        $payment = Payment::where('transaction_id', $orderId)->with(['class', 'bootcamp'])->first();

        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found');
        }

        // Ensure auto-enrollment is processed if payment is completed
        if ($payment->status === 'completed') {
            $this->autoEnrollUser($payment);
            
            // Refresh payment to get updated relationships
            $payment = $payment->fresh(['class', 'bootcamp']);
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
