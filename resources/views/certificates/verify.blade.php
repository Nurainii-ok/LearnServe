<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification - {{ $certificate->certificate_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gold: #ecac57;
            --primary-brown: #944e25;
            --light-cream: #f3efec;
            --deep-brown: #6b3419;
            --soft-gold: #f4d084;
            --success-green: #4a7c59;
            --text-primary: #2c2c2c;
            --text-secondary: #666666;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
            min-height: 100vh;
        }
        
        .certificate-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .certificate-card {
            border: 3px solid var(--primary-gold);
            border-radius: 20px;
            background: white;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        
        .certificate-header {
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
            color: white;
            text-align: center;
            padding: 40px 30px;
            position: relative;
        }
        
        .certificate-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .certificate-body {
            padding: 50px 40px;
            text-align: center;
            position: relative;
        }
        
        .logo-section {
            margin-bottom: 30px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-gold) 0%, var(--soft-gold) 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
            box-shadow: 0 10px 30px rgba(148, 78, 37, 0.3);
        }
        
        .verification-badge {
            background: var(--success-green);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(74, 124, 89, 0.3);
        }
        
        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
        }
        
        .certificate-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }
        
        .student-info {
            background: var(--light-gray);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            border-left: 5px solid var(--primary-gold);
        }
        
        .student-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-brown);
            margin-bottom: 10px;
        }
        
        .bootcamp-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-gold);
            margin-bottom: 15px;
        }
        
        .completion-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .detail-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .detail-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }
        
        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-brown);
        }
        
        .certificate-footer {
            background: var(--light-gray);
            padding: 30px;
            border-top: 1px solid #e9ecef;
            text-align: center;
        }
        
        .authenticity-note {
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.6;
        }
        
        .certificate-id {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--primary-brown);
            font-weight: 600;
            margin-top: 15px;
            background: var(--light-cream);
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .certificate-container { max-width: none; padding: 0; }
        }
        
        @media (max-width: 768px) {
            .certificate-body { padding: 30px 20px; }
            .student-name { font-size: 1.8rem; }
            .certificate-title { font-size: 2rem; }
            .completion-details { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="certificate-container">
            <!-- Navigation -->
            <div class="mb-4 no-print">
                <a href="{{ route('home') }}" class="btn btn-outline-light">
                    <i class="las la-arrow-left"></i> Back to Website
                </a>
                <button onclick="window.print()" class="btn btn-light float-end">
                    <i class="las la-print"></i> Print Certificate
                </button>
            </div>

            <!-- Certificate -->
            <div class="certificate-card">
                <div class="certificate-header">
                    <div class="logo-section">
                        <div class="logo">LS</div>
                    </div>
                    <h1 class="certificate-title">CERTIFICATE VERIFICATION</h1>
                    <p class="certificate-subtitle">LearnServe Learning Platform</p>
                </div>
                
                <div class="certificate-body">
                    <div class="verification-badge">
                        <i class="las la-check-circle"></i> VERIFIED CERTIFICATE
                    </div>
                    
                    <div class="student-info">
                        <h2 class="student-name">{{ $certificate->user->name }}</h2>
                        <div class="bootcamp-title">{{ $certificate->bootcamp->title }}</div>
                        <p class="mb-0 text-muted">has successfully completed this bootcamp program</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">STUDENT INFORMATION</h6>
                                    <h5 class="text-primary">{{ $certificate->user->name }}</h5>
                                    <p class="mb-0">{{ $certificate->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">CERTIFICATE DETAILS</h6>
                                    <p class="mb-1"><strong>Certificate #:</strong> {{ $certificate->certificate_number }}</p>
                                    <p class="mb-1"><strong>Type:</strong> {{ ucfirst($certificate->type) }} Certificate</p>
                                    @if($certificate->final_score)
                                        <p class="mb-0"><strong>Final Score:</strong> {{ $certificate->final_score }}/100</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($certificate->description)
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Description</h6>
                            <p class="mb-0">{{ $certificate->description }}</p>
                        </div>
                    @endif
                    
                    <div class="row mt-4">
                        @if($certificate->task)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted">TASK COMPLETED</h6>
                                        <h6 class="text-dark">{{ $certificate->task->title }}</h6>
                                        <p class="small text-muted mb-0">{{ $certificate->task->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($certificate->class)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted">CLASS</h6>
                                        <h6 class="text-dark">{{ $certificate->class->title }}</h6>
                                        <p class="small text-muted mb-0">{{ $certificate->class->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">COMPLETION DATE</h6>
                                    <h5 class="text-success">{{ $certificate->completion_date->format('F d, Y') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">ISSUED BY</h6>
                                    @if($certificate->issuedBy)
                                        <h6 class="text-dark">{{ $certificate->issuedBy->name }}</h6>
                                        <p class="small text-muted mb-0">{{ ucfirst($certificate->issuedBy->role) }}</p>
                                    @else
                                        <h6 class="text-dark">LearnServe System</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted small mb-0">
                            This certificate is digitally verified and authentic. 
                            Generated on {{ now()->format('F d, Y \a\t H:i') }}
                        </p>
                        <p class="text-muted small">
                            Verification URL: {{ request()->url() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info -->
            <div class="mt-4 no-print">
                <div class="alert alert-success">
                    <h6 class="alert-heading">
                        <i class="las la-shield-alt"></i> Certificate Verified Successfully
                    </h6>
                    <p class="mb-0">
                        This certificate has been verified as authentic and was issued by LearnServe Learning Platform. 
                        The certificate holder has successfully completed the requirements for this achievement.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>