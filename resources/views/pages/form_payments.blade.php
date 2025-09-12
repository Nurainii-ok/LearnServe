<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kelas - LearnServe</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gold: #ecac57;
            --primary-brown: #944e25;
            --light-cream: #f3efec;
            --deep-brown: #6b3419;
            --soft-gold: #f4d084;
            --text-primary: #2c2c2c;
            --text-secondary: #666666;
            --background-light: #f8f8f8;
            --white: #ffffff;
            --success-green: #4a7c59;
            --info-blue: #5b7c8a;
            --alert-orange: #d97435;
            --border-color: #e0e0e0;
            --error-red: #dc2626;
            --shadow: 0 2px 8px rgba(0,0,0,0.1);
            --shadow-lg: 0 4px 16px rgba(0,0,0,0.15);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--light-cream) 0%, var(--background-light) 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: var(--white);
            padding: 16px 0;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-brown);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .breadcrumb a {
            color: var(--primary-brown);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Main Container */
        .payment-container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 32px;
        }

        /* Left Section */
        .payment-form-section {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .section-header {
            padding: 24px;
            background: var(--light-cream);
            border-bottom: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .section-subtitle {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .section-content {
            padding: 24px;
        }

        /* Payment Methods */
        .payment-methods {
            margin-bottom: 32px;
        }

        .method-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .method-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .method-option {
            display: flex;
            align-items: center;
            padding: 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .method-option:hover {
            border-color: var(--primary-gold);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .method-option.selected {
            border-color: var(--primary-brown);
            background: var(--light-cream);
        }

        .method-option input[type="radio"] {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-brown);
        }

        .method-info {
            flex: 1;
        }

        .method-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .method-desc {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .method-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-left: 12px;
        }

        /* Payment Details Form */
        .payment-details {
            display: none;
        }

        .payment-details.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
        }

        .form-input.error {
            border-color: var(--error-red);
        }

        .error-message {
            color: var(--error-red);
            font-size: 0.8rem;
            margin-top: 4px;
            display: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
        }

        /* Bank Transfer Info */
        .bank-info {
            background: var(--light-cream);
            padding: 20px;
            border-radius: 12px;
            margin-top: 16px;
        }

        .bank-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .bank-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .bank-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .bank-account {
            font-family: monospace;
            color: var(--primary-brown);
            font-weight: 600;
        }

        /* Right Section */
        .order-summary {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Course Info */
        .course-info {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .course-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--primary-gold) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--white);
        }

        .course-details {
            padding: 20px;
        }

        .course-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .course-instructor {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .course-features {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .feature-icon {
            width: 16px;
            height: 16px;
            background: var(--success-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.7rem;
        }

        /* Price Summary */
        .price-summary {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .price-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-brown);
            margin-top: 8px;
            padding-top: 16px;
            border-top: 2px solid var(--border-color);
        }

        .price-label {
            color: var(--text-secondary);
        }

        .price-value {
            font-weight: 500;
        }

        .discount-badge {
            background: var(--alert-orange);
            color: var(--white);
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary-brown);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--deep-brown);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:disabled {
            background: var(--text-secondary);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-secondary {
            background: var(--white);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--light-cream);
        }

        /* Security Badge */
        .security-badge {
            background: var(--light-cream);
            padding: 16px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .security-icon {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .security-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Loading State */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid var(--white);
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-container {
                grid-template-columns: 1fr;
                gap: 24px;
                padding: 0 16px;
            }

            .header-container {
                padding: 0 16px;
            }

            .section-content {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .course-image {
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo">LearnServe</div>
            <nav class="breadcrumb">
                <a href="{{ route('learning') }}">← Kembali</a>
                <span>/</span>
                <span>Pembayaran</span>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="payment-container">
        <!-- Left Section - Payment Form -->
        <div class="payment-form-section">
            <div class="section-header">
                <h2 class="section-title">Metode Pembayaran</h2>
                <p class="section-subtitle">Pilih metode pembayaran yang Anda inginkan</p>
            </div>
            
            <div class="section-content">
                <!-- Payment Methods -->
                <div class="payment-methods">
                    <div class="method-options">
                        <label class="method-option" for="bank-transfer">
                            <input type="radio" id="bank-transfer" name="payment-method" value="bank-transfer" checked>
                            <div class="method-info">
                                <div class="method-name">Transfer Bank</div>
                                <div class="method-desc">Transfer melalui ATM, Internet Banking, atau Mobile Banking</div>
                            </div>
                            <div class="method-icon">🏦</div>
                        </label>

                        <label class="method-option" for="e-wallet">
                            <input type="radio" id="e-wallet" name="payment-method" value="e-wallet">
                            <div class="method-info">
                                <div class="method-name">E-Wallet</div>
                                <div class="method-desc">Pembayaran melalui GoPay, OVO, Dana, LinkAja</div>
                            </div>
                            <div class="method-icon">📱</div>
                        </label>

                        <label class="method-option" for="credit-card">
                            <input type="radio" id="credit-card" name="payment-method" value="credit-card">
                            <div class="method-info">
                                <div class="method-name">Kartu Kredit/Debit</div>
                                <div class="method-desc">Visa, Mastercard, JCB (diproses otomatis)</div>
                            </div>
                            <div class="method-icon">💳</div>
                        </label>
                    </div>
                </div>

                <!-- Bank Transfer Details -->
                <div id="bank-transfer-details" class="payment-details active">
                    <h3 class="method-title">Informasi Transfer Bank</h3>
                    <div class="bank-info">
                        <div class="bank-details">
                            <div class="bank-item">
                                <div>
                                    <div class="bank-name">Bank Mandiri</div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);">a.n. LearnServe Indonesia</div>
                                </div>
                                <div class="bank-account">1380-0123-4567</div>
                            </div>
                            <div class="bank-item">
                                <div>
                                    <div class="bank-name">Bank BCA</div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);">a.n. LearnServe Indonesia</div>
                                </div>
                                <div class="bank-account">8765-4321-00</div>
                            </div>
                            <div class="bank-item">
                                <div>
                                    <div class="bank-name">Bank BNI</div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);">a.n. LearnServe Indonesia</div>
                                </div>
                                <div class="bank-account">0987-6543-21</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="transfer-from">Bank Pengirim *</label>
                        <select class="form-input" id="transfer-from" required>
                            <option value="">Pilih bank pengirim</option>
                            <option value="mandiri">Bank Mandiri</option>
                            <option value="bca">Bank BCA</option>
                            <option value="bni">Bank BNI</option>
                            <option value="bri">Bank BRI</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="account-holder">Nama Pemegang Rekening *</label>
                        <input type="text" class="form-input" id="account-holder" placeholder="Sesuai dengan rekening bank" required>
                    </div>
                </div>

                <!-- E-Wallet Details -->
                <div id="e-wallet-details" class="payment-details">
                    <h3 class="method-title">Pilih E-Wallet</h3>
                    <div class="method-options" style="margin-bottom: 20px;">
                        <label class="method-option" for="gopay">
                            <input type="radio" id="gopay" name="ewallet-type" value="gopay">
                            <div class="method-info">
                                <div class="method-name">GoPay</div>
                            </div>
                            <div class="method-icon" style="background: #00AA13;">💚</div>
                        </label>
                        <label class="method-option" for="ovo">
                            <input type="radio" id="ovo" name="ewallet-type" value="ovo">
                            <div class="method-info">
                                <div class="method-name">OVO</div>
                            </div>
                            <div class="method-icon" style="background: #4C2783;">💜</div>
                        </label>
                        <label class="method-option" for="dana">
                            <input type="radio" id="dana" name="ewallet-type" value="dana">
                            <div class="method-info">
                                <div class="method-name">DANA</div>
                            </div>
                            <div class="method-icon" style="background: #118EEA;">💙</div>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone-number">Nomor Handphone *</label>
                        <input type="tel" class="form-input" id="phone-number" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                <!-- Credit Card Details -->
                <div id="credit-card-details" class="payment-details">
                    <h3 class="method-title">Informasi Kartu</h3>
                    
                    <div class="form-group">
                        <label class="form-label" for="card-number">Nomor Kartu *</label>
                        <input type="text" class="form-input" id="card-number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="card-holder">Nama Pemegang Kartu *</label>
                        <input type="text" class="form-input" id="card-holder" placeholder="Sesuai dengan kartu" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="expiry-date">Tanggal Kedaluwarsa *</label>
                            <input type="text" class="form-input" id="expiry-date" placeholder="MM/YY" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cvv">CVV *</label>
                            <input type="text" class="form-input" id="cvv" placeholder="123" maxlength="3" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Order Summary -->
        <div class="order-summary">
            <!-- Course Info -->
            <div class="course-info">
                <div class="course-image">📚</div>
                <div class="course-details">
                    <h3 class="course-title">Web Development Fundamentals</h3>
                    <p class="course-instructor">Oleh John Doe</p>
                    <div class="course-features">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>30+ Video Pembelajaran</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>Sertifikat Resmi</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>Akses Selamanya</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>Forum Diskusi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Summary -->
            <div class="price-summary">
                <div class="price-row">
                    <span class="price-label">Harga Kelas</span>
                    <span class="price-value">Rp 299.000</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Diskon Early Bird <span class="discount-badge">20%</span></span>
                    <span class="price-value" style="color: var(--alert-orange);">-Rp 59.800</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Biaya Admin</span>
                    <span class="price-value">Rp 2.500</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Total Pembayaran</span>
                    <span class="price-value">Rp 241.700</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn btn-primary" id="pay-button" onclick="processPayment()">
                    Bayar Sekarang
                </button>
                <button class="btn btn-secondary" onclick="window.location='{{ route('learning') }}'">
                    Kembali ke Kelas
                </button>

            </div>

            <!-- Security Badge -->
            <div class="security-badge">
                <div class="security-icon">🔒</div>
                <div class="security-text">
                    Pembayaran aman dengan enkripsi SSL 256-bit
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment method selection
        const paymentMethods = document.querySelectorAll('input[name="payment-method"]');
        const paymentDetails = document.querySelectorAll('.payment-details');
        const methodOptions = document.querySelectorAll('.method-option');

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                // Update method option styling
                methodOptions.forEach(option => option.classList.remove('selected'));
                this.closest('.method-option').classList.add('selected');

                // Show corresponding payment details
                paymentDetails.forEach(detail => detail.classList.remove('active'));
                const targetDetail = document.getElementById(this.value + '-details');
                if (targetDetail) {
                    targetDetail.classList.add('active');
                }
            });
        });

        // Initialize first option as selected
        document.querySelector('.method-option').classList.add('selected');

        // Card number formatting
        const cardNumberInput = document.getElementById('card-number');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                this.value = formattedValue;
            });
        }

        // Expiry date formatting
        const expiryInput = document.getElementById('expiry-date');
        if (expiryInput) {
            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                this.value = value;
            });
        }

        // Phone number formatting
        const phoneInput = document.getElementById('phone-number');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    this.value = value;
                } else if (value.startsWith('8')) {
                    this.value = '0' + value;
                }
            });
        }

        // Form validation
        function validateForm() {
            const selectedMethod = document.querySelector('input[name="payment-method"]:checked').value;
            let isValid = true;
            const requiredFields = [];

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(msg => {
                msg.style.display = 'none';
            });
            document.querySelectorAll('.form-input').forEach(input => {
                input.classList.remove('error');
            });

            if (selectedMethod === 'bank-transfer') {
                requiredFields.push('transfer-from', 'account-holder');
            } else if (selectedMethod === 'e-wallet') {
                requiredFields.push('phone-number');
                const ewalletType = document.querySelector('input[name="ewallet-type"]:checked');
                if (!ewalletType) {
                    alert('Pilih jenis e-wallet terlebih dahulu');
                    return false;
                }
            } else if (selectedMethod === 'credit-card') {
                requiredFields.push('card-number', 'card-holder', 'expiry-date', 'cvv');
            }

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('error');
                    isValid = false;
                }
            });

            return isValid;
        }

        // Process payment
        function processPayment() {
            if (!validateForm()) {
                alert('Mohon lengkapi semua field yang diperlukan');
                return;
            }

            const payButton = document.getElementById('pay-button');
            const selectedMethod = document.querySelector('input[name="payment-method"]:checked').value;
            
            // Show loading state
            payButton.innerHTML = '<span class="spinner"></span>Memproses...';
            payButton.disabled = true;
            document.body.classList.add('loading');

            // Simulate payment processing
            setTimeout(() => {
                if (selectedMethod === 'bank-transfer') {
                    // Redirect to payment instructions
                    alert('Silakan transfer ke salah satu rekening yang tersedia dan upload bukti transfer.');
                    window.location.href = '#payment-instructions';
                } else if (selectedMethod === 'e-wallet') {
                    // Redirect to e-wallet
                    alert('Anda akan diarahkan ke aplikasi e-wallet untuk menyelesaikan pembayaran.');
                    window.location.href = '#ewallet-redirect';
                } else if (selectedMethod === 'credit-card') {
                    // Process credit card
                    alert('Pembayaran berhasil diproses! Anda akan segera mendapatkan akses ke kelas.');
                    window.location.href = '#payment-success';
                }

                // Reset button state
                payButton.innerHTML = 'Bayar Sekarang';
                payButton.disabled = false;
                document.body.classList.remove('loading');
            }, 2000);
        }

                // Go back function
        function goBack() {
            if (confirm('Yakin ingin kembali? Data pembayaran yang sudah diisi bisa hilang.')) {
                window.history.back();
            }
        }
