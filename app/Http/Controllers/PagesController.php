<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\User;
use App\Models\Payment;

class PagesController extends Controller
{
    public function home()
    {
        // Get popular classes for homepage
        $popularClasses = Classes::with(['tutor', 'payments'])
            ->where('status', 'active')
            ->withCount('payments')
            ->orderBy('payments_count', 'desc')
            ->take(6)
            ->get();
            
        return view('pages.home', compact('popularClasses'));
    }

    public function learning()
    {
        // Get all active classes with filtering and pagination
        $query = Classes::with(['tutor', 'payments'])
            ->where('status', 'active');
            
        // Filter by category if provided
        if (request('category') && request('category') !== 'all') {
            $query->where('category', request('category'));
        }
        
        // Search functionality
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }
        
        $classes = $query->latest()->paginate(12);
        
        // Get unique categories for filter
        $categories = Classes::where('status', 'active')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
            
        return view('pages.learning', compact('classes', 'categories'));
    }

    public function bootcamp()
    {
        // Get all active bootcamp programs from the Bootcamp model
        $bootcamps = Bootcamp::with(['tutor'])
            ->where('status', 'active')
            ->latest()
            ->get();
            
        return view('pages.bootcamp', compact('bootcamps'));
    }

    public function webinar()
    {
        // Get webinar classes
        $webinarClasses = Classes::with(['tutor', 'payments'])
            ->where('status', 'active')
            ->where('category', 'like', '%webinar%')
            ->latest()
            ->get();
            
        return view('pages.webinar', compact('webinarClasses'));
    }

    public function deskripsibootcamp($id = null)
    {
        // Get bootcamp details by ID if provided
        $bootcamp = null;
        
        if ($id) {
            $bootcamp = Bootcamp::with(['tutor'])
                ->where('status', 'active')
                ->findOrFail($id);
        }
        
        return view('pages.deskripsi_bootcamp', compact('bootcamp'));
    }

    public function detailKursus()
    {
        // Get class details by ID if provided
        $classId = request('id');
        $class = null;
        
        if ($classId) {
            $class = Classes::with(['tutor', 'payments', 'tasks'])
                ->where('status', 'active')
                ->findOrFail($classId);
        }
        
        return view('pages.detail_kursus', compact('class'));
    }

    public function formPayments()
    {
        $classId = request('class_id');
        $class = null;
        
        if ($classId) {
            $class = Classes::with('tutor')
                ->where('status', 'active')
                ->findOrFail($classId);
        }
        
        return view('pages.form_payments', compact('class'));
    }

    public function beliSekarang()
    {
        $classId = request('class_id');
        $course = null;
        
        if ($classId) {
            $course = Classes::with('tutor')
                ->where('status', 'active')
                ->findOrFail($classId);
        }
        
        return view('pages.beli_sekarang', compact('course'));
    }

    public function processCheckout(Request $request)
    {
        try {
            // Validate the checkout form data
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'whatsapp' => 'nullable|string|max:20',
                'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card',
                'notes' => 'nullable|string|max:1000',
                'terms' => 'required|accepted',
            ]);

            // Get class information if class_id is provided
            $classId = $request->input('class_id');
            $class = null;
            if ($classId) {
                $class = Classes::findOrFail($classId);
            }

            // Calculate total price
            $coursePrice = $class ? $class->price : 500000; // Default price if no class
            $adminFee = 5000;
            $totalPrice = $coursePrice + $adminFee;

            // Create payment record
            $payment = Payment::create([
                'user_id' => session('user_id') ?: null, // Using session-based auth, null if not logged in
                'class_id' => $classId,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'whatsapp' => $validated['whatsapp'],
                'payment_method' => $validated['payment_method'],
                'transaction_id' => 'TXN-' . time() . '-' . rand(1000, 9999),
                'amount' => $totalPrice,
                'status' => 'pending',
                'notes' => $validated['notes'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate payment instructions based on method
            $paymentInstructions = $this->generatePaymentInstructions($validated['payment_method'], $payment->id, $totalPrice);

            // Redirect to success page with payment details
            return redirect()->route('checkout.success')
                ->with('success', 'Pesanan berhasil dibuat!')
                ->with('payment', $payment)
                ->with('instructions', $paymentInstructions);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    private function generatePaymentInstructions($paymentMethod, $paymentId, $amount)
    {
        $instructions = [];
        
        switch ($paymentMethod) {
            case 'bank_transfer':
                $instructions = [
                    'title' => 'Transfer Bank',
                    'steps' => [
                        'Transfer ke salah satu rekening bank berikut:',
                        'BCA: 1234567890 A.n LearnServe',
                        'BNI: 0987654321 A.n LearnServe', 
                        'BRI: 1122334455 A.n LearnServe',
                        'Jumlah transfer: Rp ' . number_format($amount, 0, ',', '.'),
                        'Kode pembayaran: PAY-' . $paymentId,
                        'Kirim bukti transfer ke WhatsApp: 08123456789'
                    ]
                ];
                break;
                
            case 'e_wallet':
                $instructions = [
                    'title' => 'E-Wallet',
                    'steps' => [
                        'Pilih e-wallet yang Anda gunakan (GoPay/OVO/DANA)',
                        'Scan QR Code yang akan dikirimkan ke email Anda',
                        'Atau transfer ke nomor: 08123456789',
                        'Jumlah transfer: Rp ' . number_format($amount, 0, ',', '.'),
                        'Kode pembayaran: PAY-' . $paymentId
                    ]
                ];
                break;
                
            case 'credit_card':
                $instructions = [
                    'title' => 'Kartu Kredit',
                    'steps' => [
                        'Anda akan dialihkan ke halaman pembayaran kartu kredit',
                        'Masukkan detail kartu kredit Anda',
                        'Ikuti instruksi untuk menyelesaikan pembayaran',
                        'Simpan nomor referensi: PAY-' . $paymentId
                    ]
                ];
                break;
        }
        
        return $instructions;
    }

    public function checkoutSuccess()
    {
        return view('pages.checkout_success');
    }

    public function formPendaftaran()
    {
        return view('pages.form_pendaftaran');
    }

    public function kelas()
    {
        // Get all classes with filtering
        $query = Classes::with(['tutor', 'payments'])
            ->where('status', 'active');
            
        // Filter by category
        if (request('category') && request('category') !== 'all') {
            $query->where('category', request('category'));
        }
        
        // Search functionality
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }
        
        $classes = $query->latest()->paginate(12);
        
        // Get categories for filter
        $categories = Classes::where('status', 'active')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
            
        return view('pages.kelas', compact('classes', 'categories'));
    }

    public function checkout()
    {
        // kalau nanti checkout butuh data kelas/pembayaran, bisa dioper dari sini
        return view('pages.checkout');
    }
}
