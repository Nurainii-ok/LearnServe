<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Bootcamp - LearnServe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Brand Colors */
            --primary-gold: #ecac57;
            --primary-brown: #944e25;
            --light-cream: #f3efec;
            --deep-brown: #6b3419;
            --soft-gold: #f4d084;
            
            /* Supporting Colors */
            --text-primary: #2c2c2c;
            --text-secondary: #666666;
            --background-light: #fefefe;
            --background-section: #f8f8f8;
            --success-green: #4a7c59;
            --error-red: #d73527;
            --border-light: #e5e5e5;
            --border-focus: #ecac57;
            
            /* Shadows */
            --shadow-light: 0 2px 12px rgba(107, 52, 25, 0.08);
            --shadow-medium: 0 4px 20px rgba(107, 52, 25, 0.12);
            --shadow-hover: 0 8px 32px rgba(107, 52, 25, 0.15);
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: linear-gradient(135deg, var(--light-cream) 0%, #f9f6f3 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Header */
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .form-header p {
            font-size: 18px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Progress Indicator */
        .progress-container {
            background: var(--background-light);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-light);
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 15px;
            right: -50%;
            width: 100%;
            height: 2px;
            background: var(--border-light);
            z-index: 1;
        }

        .step.active:not(:last-child)::after {
            background: var(--primary-gold);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--border-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-secondary);
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .step.active .step-circle {
            background: var(--primary-gold);
            color: var(--text-primary);
        }

        .step.completed .step-circle {
            background: var(--success-green);
            color: white;
        }

        .step-label {
            font-size: 12px;
            margin-top: 8px;
            color: var(--text-secondary);
        }

        .step.active .step-label {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Form Container */
        .form-container {
            background: var(--background-light);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-light);
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Form Groups */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .required {
            color: var(--error-red);
        }

        /* Input Styles */
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-light);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--background-light);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px rgba(236, 172, 87, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Program Selection */
        .program-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .program-option {
            position: relative;
        }

        .program-option input[type="radio"] {
            display: none;
        }

        .program-card {
            background: var(--background-section);
            border: 2px solid var(--border-light);
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .program-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .program-option input[type="radio"]:checked + .program-card {
            border-color: var(--primary-gold);
            background: var(--light-cream);
        }

        .program-option input[type="radio"]:checked + .program-card::before {
            content: '✓';
            position: absolute;
            top: 12px;
            right: 12px;
            width: 24px;
            height: 24px;
            background: var(--success-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }

        .program-name {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .program-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-brown);
            margin-bottom: 4px;
        }

        .program-duration {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Checkbox and Radio Styles */
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 20px;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
        }

        .checkbox-label {
            font-size: 14px;
            line-height: 1.5;
            color: var(--text-secondary);
        }

        .checkbox-label a {
            color: var(--primary-brown);
            text-decoration: none;
        }

        .checkbox-label a:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .form-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid var(--border-light);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary-gold);
            color: var(--text-primary);
        }

        .btn-primary:hover {
            background: var(--soft-gold);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-secondary);
            border: 2px solid var(--border-light);
        }

        .btn-secondary:hover {
            border-color: var(--primary-brown);
            color: var(--primary-brown);
        }

        .btn-success {
            background: var(--success-green);
            color: white;
            font-size: 16px;
            padding: 16px 32px;
        }

        .btn-success:hover {
            background: #3d6b4a;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        /* Error Styles */
        .error-message {
            color: var(--error-red);
            font-size: 14px;
            margin-top: 4px;
        }

        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: var(--error-red);
        }

        /* Success Message */
        .success-message {
            text-align: center;
            padding: 60px 40px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--success-green);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            margin-bottom: 24px;
        }

        .success-message h2 {
            font-size: 28px;
            margin-bottom: 16px;
            color: var(--text-primary);
        }

        .success-message p {
            color: var(--text-secondary);
            margin-bottom: 32px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }
            
            .form-container {
                padding: 24px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .program-selection {
                grid-template-columns: 1fr;
            }
            
            .form-header h1 {
                font-size: 28px;
            }
            
            .step-title {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 0;
            }
            
            .progress-steps {
                flex-direction: column;
                gap: 16px;
            }
            
            .step:not(:last-child)::after {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h1><i class="fas fa-graduation-cap"></i> Daftar Bootcamp</h1>
            <p>Isi form berikut untuk memulai perjalanan belajar Anda bersama LearnServe</p>
        </div>

        <div class="progress-container">
            <div class="progress-steps">
                <div class="step active" id="step-indicator-1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Pilih Program</div>
                </div>
                <div class="step" id="step-indicator-2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Data Pribadi</div>
                </div>
                <div class="step" id="step-indicator-3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form id="registrationForm">
                <!-- Step 1: Program Selection -->
                <div class="form-step active" id="step-1">
                    <h2 class="step-title">
                        <i class="fas fa-laptop-code"></i>
                        Pilih Program Bootcamp
                    </h2>
                    
                    <div class="program-selection">
                        <label class="program-option">
                            <input type="radio" name="program" value="digital-marketing" required>
                            <div class="program-card">
                                <div class="program-name">Digital Marketing Mastery</div>
                                <div class="program-price">Rp 2.500.000</div>
                                <div class="program-duration">3 bulan • Online</div>
                            </div>
                        </label>
                        
                        <label class="program-option">
                            <input type="radio" name="program" value="web-development" required>
                            <div class="program-card">
                                <div class="program-name">Full Stack Web Development</div>
                                <div class="program-price">Rp 4.500.000</div>
                                <div class="program-duration">6 bulan • Online</div>
                            </div>
                        </label>
                        
                        <label class="program-option">
                            <input type="radio" name="program" value="data-science" required>
                            <div class="program-card">
                                <div class="program-name">Data Science & Analytics</div>
                                <div class="program-price">Rp 5.000.000</div>
                                <div class="program-duration">6 bulan • Online</div>
                            </div>
                        </label>
                        
                        <label class="program-option">
                            <input type="radio" name="program" value="ui-ux-design" required>
                            <div class="program-card">
                                <div class="program-name">UI/UX Design Professional</div>
                                <div class="program-price">Rp 3.500.000</div>
                                <div class="program-duration">4 bulan • Online</div>
                            </div>
                        </label>
                        
                        <label class="program-option">
                            <input type="radio" name="program" value="mobile-development" required>
                            <div class="program-card">
                                <div class="program-name">Mobile App Development</div>
                                <div class="program-price">Rp 4.000.000</div>
                                <div class="program-duration">5 bulan • Online</div>
                            </div>
                        </label>
                        
                        <label class="program-option">
                            <input type="radio" name="program" value="cybersecurity" required>
                            <div class="program-card">
                                <div class="program-name">Cybersecurity Specialist</div>
                                <div class="program-price">Rp 5.500.000</div>
                                <div class="program-duration">6 bulan • Online</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Personal Information -->
                <div class="form-step" id="step-2">
                    <h2 class="step-title">
                        <i class="fas fa-user"></i>
                        Data Pribadi
                    </h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" class="form-input" name="fullName" required placeholder="Masukkan nama lengkap">
                            <div class="error-message" id="fullName-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-input" name="email" required placeholder="nama@email.com">
                            <div class="error-message" id="email-error"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">No. WhatsApp <span class="required">*</span></label>
                            <input type="tel" class="form-input" name="phone" required placeholder="08xxxxxxxxxx">
                            <div class="error-message" id="phone-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                            <input type="date" class="form-input" name="birthDate" required>
                            <div class="error-message" id="birthDate-error"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Pendidikan Terakhir <span class="required">*</span></label>
                            <select class="form-select" name="education" required>
                                <option value="">Pilih pendidikan terakhir</option>
                                <option value="sma">SMA/SMK</option>
                                <option value="d3">Diploma III</option>
                                <option value="s1">Sarjana (S1)</option>
                                <option value="s2">Magister (S2)</option>
                                <option value="s3">Doktor (S3)</option>
                            </select>
                            <div class="error-message" id="education-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Status Pekerjaan <span class="required">*</span></label>
                            <select class="form-select" name="jobStatus" required>
                                <option value="">Pilih status pekerjaan</option>
                                <option value="student">Mahasiswa</option>
                                <option value="fresh-graduate">Fresh Graduate</option>
                                <option value="employed">Karyawan</option>
                                <option value="freelancer">Freelancer</option>
                                <option value="entrepreneur">Entrepreneur</option>
                                <option value="unemployed">Tidak Bekerja</option>
                            </select>
                            <div class="error-message" id="jobStatus-error"></div>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                        <textarea class="form-textarea" name="address" required placeholder="Masukkan alamat lengkap"></textarea>
                        <div class="error-message" id="address-error"></div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label class="form-label">Motivasi & Tujuan</label>
                        <textarea class="form-textarea" name="motivation" placeholder="Ceritakan motivasi dan tujuan Anda mengikuti bootcamp ini"></textarea>
                    </div>
                </div>

                <!-- Step 3: Confirmation -->
                <div class="form-step" id="step-3">
                    <h2 class="step-title">
                        <i class="fas fa-check-circle"></i>
                        Konfirmasi Pendaftaran
                    </h2>
                    
                    <div id="registration-summary">
                        <!-- Summary will be populated by JavaScript -->
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox-input" name="terms" required id="terms">
                        <label class="checkbox-label" for="terms">
                            Saya telah membaca dan menyetujui <a href="#" target="_blank">syarat dan ketentuan</a> serta <a href="#" target="_blank">kebijakan privasi</a> LearnServe.
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox-input" name="newsletter" id="newsletter">
                        <label class="checkbox-label" for="newsletter">
                            Saya ingin menerima informasi terbaru tentang program dan promo dari LearnServe.
                        </label>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="form-step" id="success-step">
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h2>Pendaftaran Berhasil!</h2>
                        <p>Terima kasih telah mendaftar. Tim kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi dan informasi pembayaran.</p>
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-home"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <div class="form-navigation">
                    <button type="button" class="btn btn-secondary" id="prevBtn" style="visibility: hidden;">
                        <i class="fas fa-arrow-left"></i>
                        Sebelumnya
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn">
                        Selanjutnya
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;
        const formData = {};

        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const form = document.getElementById('registrationForm');

        // Initialize form
        updateStepDisplay();

        nextBtn.addEventListener('click', function() {
            if (currentStep < totalSteps) {
                if (validateStep(currentStep)) {
                    saveStepData(currentStep);
                    currentStep++;
                    updateStepDisplay();
                    
                    if (currentStep === 3) {
                        showSummary();
                    }
                }
            } else {
                // Submit form
                if (validateStep(currentStep)) {
                    submitForm();
                }
            }
        });

        prevBtn.addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateStepDisplay();
            }
        });

        function updateStepDisplay() {
            // Update step indicators
            for (let i = 1; i <= totalSteps; i++) {
                const stepIndicator = document.getElementById(`step-indicator-${i}`);
                const stepElement = document.getElementById(`step-${i}`);
                
                stepIndicator.classList.remove('active', 'completed');
                stepElement.classList.remove('active');
                
                if (i < currentStep) {
                    stepIndicator.classList.add('completed');
                } else if (i === currentStep) {
                    stepIndicator.classList.add('active');
                    stepElement.classList.add('active');
                }
            }
            
            // Update navigation buttons
            prevBtn.style.visibility = currentStep === 1 ? 'hidden' : 'visible';
            
            if (currentStep === totalSteps) {
                nextBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Daftar Sekarang';
            } else {
                nextBtn.innerHTML = 'Selanjutnya <i class="fas fa-arrow-right"></i>';
            }
            
            // Hide navigation on success
            if (document.getElementById('success-step').classList.contains('active')) {
                document.querySelector('.form-navigation').style.display = 'none';
            }
        }

        function validateStep(step) {
            let isValid = true;
            const currentStepElement = document.getElementById(`step-${step}`);
            const inputs = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                const errorElement = document.getElementById(`${input.name}-error`);
                
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                    if (errorElement) {
                        errorElement.textContent = 'Field ini wajib diisi';
                    }
                } else {
                    input.classList.remove('error');
                    if (errorElement) {
                        errorElement.textContent = '';
                    }
                    
                    // Email validation
                    if (input.type === 'email' && !isValidEmail(input.value)) {
                        isValid = false;
                        input.classList.add('error');
                        if (errorElement) {
                            errorElement.textContent = 'Format email tidak valid';
                        }
                    }
                    
                    // Phone validation
                    if (input.name === 'phone' && !isValidPhone(input.value)) {
                        isValid = false;
                        input.classList.add('error');
                        if (errorElement) {
                            errorElement.textContent = 'Format nomor WhatsApp tidak valid';
                        }
                    }
                }
            });
            
            // Special validation for step 3 (terms checkbox)
            if (step === 3) {
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    isValid = false;
                    alert('Anda harus menyetujui syarat dan ketentuan untuk melanjutkan.');
                }
            }
            
            return isValid;
        }

        function saveStepData(step) {
            const currentStepElement = document.getElementById(`step-${step}`);
            const inputs = currentStepElement.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                if (input.type === 'radio') {
                    if (input.checked) {
                        formData[input.name] = input.value;
                    }
                } else if (input.type === 'checkbox') {
                    formData[input.name] = input.checked;
                } else {
                    formData[input.name] = input.value;
                }
            });
        }

        function showSummary() {
    const programNames = {
        'digital-marketing': 'Digital Marketing Mastery',
        'web-development': 'Full Stack Web Development',
        'data-science': 'Data Science & Analytics',
        'ui-ux-design': 'UI/UX Design Professional',
        'mobile-development': 'Mobile App Development',
        'cybersecurity': 'Cybersecurity Specialist'
    };
    
    const programPrices = {
        'digital-marketing': 'Rp 2.500.000',
        'web-development': 'Rp 4.500.000',
        'data-science': 'Rp 5.000.000',
        'ui-ux-design': 'Rp 3.500.000',
        'mobile-development': 'Rp 4.000.000',
        'cybersecurity': 'Rp 5.500.000'
    };
    
    const summaryHTML = `
        <div style="background: var(--background-section); padding: 24px; border-radius: 16px; margin-bottom: 24px;">
            <h3 style="margin-bottom: 16px; color: var(--text-primary);">Ringkasan Pendaftaran</h3>
            <div style="display: grid; gap: 12px;">
                <div style="display: flex; justify-content: space-between;">
                    <span>Program:</span>
                    <strong>${programNames[formData.program] || formData.program}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Harga:</span>
                    <strong style="color: var(--primary-brown);">${programPrices[formData.program] || 'N/A'}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Nama:</span>
                    <strong>${formData.fullName}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Email:</span>
                    <strong>${formData.email}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>WhatsApp:</span>
                    <strong>${formData.phone}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Pendidikan:</span>
                    <strong>${getEducationLabel(formData.education)}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Status:</span>
                    <strong>${getJobStatusLabel(formData.jobStatus)}</strong>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('registration-summary').innerHTML = summaryHTML;
}


        function getEducationLabel(value) {
            const labels = {
                'sma': 'SMA/SMK',
                'd3': 'Diploma III',
                's1': 'Sarjana (S1)',
                's2': 'Magister (S2)',
                's3': 'Doktor (S3)'
            };
            return labels[value] || value;
        }

        function getJobStatusLabel(value) {
            const labels = {
                'student': 'Mahasiswa',
                'fresh-graduate': 'Fresh Graduate',
                'employed': 'Karyawan',
                'freelancer': 'Freelancer',
                'entrepreneur': 'Entrepreneur',
                'unemployed': 'Tidak Bekerja'
            };
            return labels[value] || value;
        }

        function submitForm() {
            // Save final step data
            saveStepData(currentStep);
            
            // Simulate form submission
            nextBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            nextBtn.disabled = true;
            
            setTimeout(() => {
                // Hide all form steps
                document.querySelectorAll('.form-step').forEach(step => {
                    step.classList.remove('active');
                });
                
                // Show success message
                document.getElementById('success-step').classList.add('active');
                
                // Update progress indicators
                document.querySelectorAll('.step').forEach(step => {
                    step.classList.remove('active');
                    step.classList.add('completed');
                });
                
                // Hide navigation
                document.querySelector('.form-navigation').style.display = 'none';
                
                console.log('Form Data:', formData);
            }, 2000);
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,9}$/;
            return phoneRegex.test(phone.replace(/\s/g, ''));
        }

        // Real-time validation
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('form-input') || 
                e.target.classList.contains('form-select') || 
                e.target.classList.contains('form-textarea')) {
                
                const errorElement = document.getElementById(`${e.target.name}-error`);
                
                if (e.target.value.trim()) {
                    e.target.classList.remove('error');
                    if (errorElement) {
                        errorElement.textContent = '';
                    }
                }
            }
        });

        // Auto-format phone number
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }
            e.target.value = value;
        });

        // Program card animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const programCards = document.querySelectorAll('.program-card');
            programCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Set initial card styles for animation
        document.querySelectorAll('.program-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
        });
    </script>
</body>
</html>
                            <span>Program:</span>
                            <strong>${programNames[formData.program] || formData.program}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">