@extends('layouts.app')
@section('title', 'Beli Sekarang - Checkout')

@section('content')
<style>
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    .checkout-header {
        background: linear-gradient(135deg, #944e25 0%, #ecac57 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(148, 78, 37, 0.3);
    }
    
    .checkout-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .checkout-form {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .section-title {
        color: #944e25;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #ecac57;
        box-shadow: 0 0 0 3px rgba(236, 172, 87, 0.1);
        outline: none;
    }
    
    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .payment-option {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    
    .payment-option:hover {
        border-color: #ecac57;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .payment-option.active {
        border-color: #944e25;
        background: #f3efec;
    }
    
    .payment-option input[type="radio"] {
        display: none;
    }
    
    .payment-logo {
        width: 60px;
        height: 40px;
        object-fit: contain;
        margin-bottom: 10px;
    }
    
    .order-summary {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    
    .course-preview {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .course-image {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }
    
    .course-details h4 {
        color: #944e25;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }
    
    .course-details p {
        color: #666;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .price-breakdown {
        margin-bottom: 20px;
    }
    
    .price-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 5px 0;
    }
    
    .price-item.total {
        border-top: 2px solid #e9ecef;
        padding-top: 15px;
        margin-top: 15px;
        font-weight: 600;
        font-size: 1.2rem;
        color: #944e25;
    }
    
    .btn-checkout {
        width: 100%;
        background: linear-gradient(135deg, #944e25 0%, #ecac57 100%);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(148, 78, 37, 0.3);
    }
    
    .security-badges {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
        opacity: 0.7;
    }
    
    .security-badge {
        font-size: 0.8rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .bank-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 15px;
        display: none;
    }
    
    .bank-details.active {
        display: block;
    }
    
    .bank-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        background: white;
        border-radius: 5px;
        border-left: 4px solid #944e25;
    }
    
    @media (max-width: 768px) {
        .checkout-content {
            grid-template-columns: 1fr;
        }
        
        .payment-methods {
            grid-template-columns: 1fr;
        }
        
        .checkout-container {
            padding: 10px;
        }
    }
</style>

<div class="checkout-container">
    <!-- Header -->
    <div class="checkout-header">
        <h1><i class="fas fa-credit-card"></i> Checkout - Beli Sekarang</h1>
        <p>Lengkapi data Anda untuk menyelesaikan pembelian kursus</p>
    </div>

    <div class="checkout-content">
        <!-- Checkout Form -->
        <div class="checkout-form">
            <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
                @csrf
                @if(isset($course))
                    <input type="hidden" name="class_id" value="{{ $course->id }}">
                @endif
                
                <!-- Customer Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Informasi Pelanggan
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" name="full_name" class="form-control" required 
                                       value="{{ auth()->user()->name ?? '' }}" placeholder="Masukkan nama lengkap">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required 
                                       value="{{ auth()->user()->email ?? '' }}" placeholder="contoh@email.com">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon *</label>
                                <input type="tel" name="phone" class="form-control" required 
                                       placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">WhatsApp</label>
                                <input type="tel" name="whatsapp" class="form-control" 
                                       placeholder="08xxxxxxxxxx (opsional)">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-credit-card"></i>
                        Metode Pembayaran
                    </h3>
                    
                    <div class="payment-methods">
                        <div class="payment-option" data-method="bank_transfer">
                            <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer">
                            <label for="bank_transfer">
                                <i class="fas fa-university" style="font-size: 2rem; color: #944e25; margin-bottom: 10px;"></i>
                                <div><strong>Transfer Bank</strong></div>
                                <small>BCA, BNI, BRI, Mandiri</small>
                            </label>
                        </div>
                        
                        <div class="payment-option" data-method="e_wallet">
                            <input type="radio" name="payment_method" value="e_wallet" id="e_wallet">
                            <label for="e_wallet">
                                <i class="fas fa-mobile-alt" style="font-size: 2rem; color: #944e25; margin-bottom: 10px;"></i>
                                <div><strong>E-Wallet</strong></div>
                                <small>GoPay, OVO, DANA</small>
                            </label>
                        </div>
                        
                        <div class="payment-option" data-method="credit_card">
                            <input type="radio" name="payment_method" value="credit_card" id="credit_card">
                            <label for="credit_card">
                                <i class="fas fa-credit-card" style="font-size: 2rem; color: #944e25; margin-bottom: 10px;"></i>
                                <div><strong>Kartu Kredit</strong></div>
                                <small>Visa, Mastercard</small>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Bank Transfer Details -->
                    <div class="bank-details" id="bank_transfer_details">
                        <h4>Pilih Bank Transfer:</h4>
                        <div class="bank-info">
                            <div>
                                <strong>BCA</strong><br>
                                <small>No. Rek: 1234567890</small>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: #944e25; font-weight: bold;">A.n LearnServe</span>
                            </div>
                        </div>
                        <div class="bank-info">
                            <div>
                                <strong>BNI</strong><br>
                                <small>No. Rek: 0987654321</small>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: #944e25; font-weight: bold;">A.n LearnServe</span>
                            </div>
                        </div>
                        <div class="bank-info">
                            <div>
                                <strong>BRI</strong><br>
                                <small>No. Rek: 1122334455</small>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: #944e25; font-weight: bold;">A.n LearnServe</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-sticky-note"></i>
                        Catatan Tambahan
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Pesan untuk Tutor (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" 
                                  placeholder="Tulis pesan atau pertanyaan untuk tutor Anda..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="terms" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#" style="color: #944e25;">Syarat dan Ketentuan</a> 
                                serta <a href="#" style="color: #944e25;">Kebijakan Privasi</a>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3 style="color: #944e25; margin-bottom: 20px;">
                <i class="fas fa-receipt"></i> Ringkasan Pesanan
            </h3>
            
            <!-- Course Preview -->
            <div class="course-preview">
                <img src="{{ asset('images/course-default.jpg') }}" alt="Course" class="course-image">
                <div class="course-details">
                    <h4>{{ $course->title ?? 'Web Development Bootcamp' }}</h4>
                    <p>{{ $course->category ?? 'Programming' }}</p>
                    <p><i class="fas fa-clock"></i> {{ $course->duration ?? '8 Weeks' }}</p>
                </div>
            </div>
            
            <!-- Price Breakdown -->
            <div class="price-breakdown">
                <div class="price-item">
                    <span>Harga Kursus</span>
                    <span>Rp {{ number_format($course->price ?? 500000, 0, ',', '.') }}</span>
                </div>
                <div class="price-item">
                    <span>Biaya Admin</span>
                    <span>Rp 5.000</span>
                </div>
                <div class="price-item">
                    <span>Diskon</span>
                    <span style="color: #28a745;">-Rp 0</span>
                </div>
                <div class="price-item total">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format(($course->price ?? 500000) + 5000, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Checkout Button -->
            <button type="submit" form="checkout-form" class="btn-checkout">
                <i class="fas fa-lock"></i> Bayar Sekarang
            </button>
            
            <!-- Security Badges -->
            <div class="security-badges">
                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i>
                    Pembayaran Aman
                </div>
                <div class="security-badge">
                    <i class="fas fa-lock"></i>
                    SSL Encrypted
                </div>
            </div>
            
            <!-- Money Back Guarantee -->
            <div style="text-align: center; margin-top: 20px; padding: 15px; background: #e8f5e8; border-radius: 8px;">
                <i class="fas fa-medal" style="color: #28a745; font-size: 1.5rem;"></i>
                <div style="margin-top: 5px; font-size: 0.9rem; color: #28a745; font-weight: 600;">
                    Garansi 30 Hari Uang Kembali
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentOptions = document.querySelectorAll('.payment-option');
        const bankDetails = document.getElementById('bank_transfer_details');
        
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                paymentOptions.forEach(opt => opt.classList.remove('active'));
                
                // Add active class to clicked option
                this.classList.add('active');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Show/hide bank details
                if (radio.value === 'bank_transfer') {
                    bankDetails.classList.add('active');
                } else {
                    bankDetails.classList.remove('active');
                }
            });
        });
        
        // Form validation
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e9ecef';
                }
            });
            
            // Check if payment method is selected
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                alert('Silakan pilih metode pembayaran!');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Silakan lengkapi semua field yang wajib diisi!');
            }
        });
        
        // Auto-format phone numbers
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Remove non-numeric characters
                let value = this.value.replace(/\D/g, '');
                
                // Format Indonesian phone number
                if (value.startsWith('0')) {
                    // Keep as is for local format
                } else if (value.startsWith('62')) {
                    // International format, convert to local
                    value = '0' + value.substring(2);
                }
                
                this.value = value;
            });
        });
    });
</script>

@endsection