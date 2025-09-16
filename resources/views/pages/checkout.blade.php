@extends('layouts.app')

@section('styles')
<style>
    .checkout-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    #pay-button {
        background-color: #944e25 !important;
        color: white !important;
        border: none !important;
        padding: 12px 20px !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        font-weight: bold !important;
        transition: all 0.3s ease !important;
        cursor: pointer !important;
        width: 100% !important;
        display: block !important;
    }
    
    #pay-button:hover {
        background-color: #7a3e1f !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(148, 78, 37, 0.3) !important;
    }
    
    #pay-button:disabled {
        background-color: #6c757d !important;
        cursor: not-allowed !important;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .order-summary {
        position: sticky;
        top: 100px;
    }
</style>
@endsection

@section('content')
<div class="container checkout-container">
    <div class="row">
        <!-- Bagian Kiri: Form -->
        <div class="col-md-7">
            <h3 class="mb-4">Checkout</h3>

            <form id="checkout-form">
                @csrf
                <input type="hidden" name="class_id" value="2" id="class_id">
                <input type="hidden" name="amount" value="169000" id="amount">

                <!-- Customer Information -->
                <div class="mb-4">
                    <h5 class="mb-3">Customer Information</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full Name *</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" 
                                   value="{{ session('username') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email *</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone Number *</label>
                            <input type="tel" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">WhatsApp (Optional)</label>
                            <input type="tel" class="form-control" name="whatsapp" id="whatsapp">
                        </div>
                    </div>
                </div>

                <!-- Alamat Penagihan -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Billing Country</label>
                    <select class="form-select">
                        <option selected>Indonesia</option>
                        <option>Malaysia</option>
                        <option>Singapore</option>
                    </select>
                    <small class="text-muted">Required for tax calculation</small>
                </div>

                <!-- Payment Method Selection -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Payment Method</label>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Choose from various payment methods including Credit Card, Bank Transfer, E-wallets, and more.
                        Payment is processed securely through Midtrans.
                    </div>
                </div>

                <!-- Detail Pesanan -->
                <div class="mt-5">
                    <h6 class="fw-bold">Order Details (1 course)</h6>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/Digital marketing.jpg') }}" 
                                 alt="thumbnail" 
                                 class="img-fluid rounded me-2" 
                                 style="width: 100px; height: auto;">
                            <span>Digital Marketing</span>
                        </div>
                        <span class="fw-bold">Rp169.000</span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bagian Kanan: Ringkasan -->
        <div class="col-md-5">
            <div class="border p-4 rounded shadow-sm order-summary">
                <h5 class="mb-3">Order Summary</h5>
                <div class="d-flex justify-content-between">
                    <span>Original Price</span>
                    <span>Rp169.000</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total (1 course)</span>
                    <span>Rp169.000</span>
                </div>
                
                <button type="button" id="pay-button" class="mt-4">
                    <i class="fas fa-credit-card me-2"></i>Beli Sekarang - Rp169.000
                </button>
                
                <div class="mt-3 text-center small text-muted">
                    <i class="fas fa-shield-alt me-1"></i>30-Day Money Back Guarantee
                </div>
                
                <div class="mt-2 text-center small text-muted">
                    Powered by <strong>Midtrans</strong> - Secure Payment Gateway
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5>Processing Payment...</h5>
                <p class="text-muted mb-0">Please wait while we process your payment.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Checkout page loaded successfully');
    
    const payButton = document.getElementById('pay-button');
    const form = document.getElementById('checkout-form');
    
    if (!payButton) {
        console.error('Pay button not found!');
        return;
    }
    
    if (!form) {
        console.error('Checkout form not found!');
        return;
    }
    
    console.log('All elements found correctly');
    
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));

    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Payment button clicked');
        
        // Validate form
        if (!validateForm()) {
            return;
        }

        // Show loading
        loadingModal.show();
        payButton.disabled = true;
        payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';

        // Prepare form data
        const formData = new FormData(form);

        // Create payment transaction
        fetch('{{ route('payment.create') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            loadingModal.hide();
            payButton.disabled = false;
            payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i>Beli Sekarang - Rp169.000';

            if (data.success) {
                console.log('Opening Midtrans Snap...');
                
                // Open Midtrans Snap
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('payment.success') }}?order_id=' + data.order_id;
                    },
                    onPending: function(result) {
                        alert('Payment is pending. Please complete your payment.');
                        window.location.href = '{{ route('payment.success') }}?order_id=' + data.order_id;
                    },
                    onError: function(result) {
                        alert('Payment failed. Please try again.');
                        window.location.href = '{{ route('payment.failed') }}';
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                    }
                });
            } else {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            loadingModal.hide();
            payButton.disabled = false;
            payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i>Beli Sekarang - Rp169.000';
            alert('Payment failed: ' + error.message);
        });
    });

    function validateForm() {
        const fullName = document.getElementById('full_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        if (!fullName) {
            alert('Please enter your full name');
            document.getElementById('full_name').focus();
            return false;
        }

        if (!email) {
            alert('Please enter your email address');
            document.getElementById('email').focus();
            return false;
        }

        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            document.getElementById('email').focus();
            return false;
        }

        if (!phone) {
            alert('Please enter your phone number');
            document.getElementById('phone').focus();
            return false;
        }

        return true;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Auto-fill WhatsApp with phone number
    document.getElementById('phone').addEventListener('input', function() {
        const whatsappField = document.getElementById('whatsapp');
        if (!whatsappField.value) {
            whatsappField.value = this.value;
        }
    });
    
    // Debug button rendering
    console.log('Button element:', payButton);
    console.log('Button text:', payButton.innerText);
    console.log('Button HTML:', payButton.innerHTML);
});
</script>
</script>
@endsection
