<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $certificate_id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #944e25 0%, #6b3419 100%);
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .certificate-container {
            width: 280mm;
            height: 190mm;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .certificate-border {
            position: absolute;
            top: 15mm;
            left: 15mm;
            right: 15mm;
            bottom: 15mm;
            border: 3px solid #ecac57;
            border-radius: 15px;
        }
        
        .certificate-inner-border {
            position: absolute;
            top: 20mm;
            left: 20mm;
            right: 20mm;
            bottom: 20mm;
            border: 1px solid #f4d084;
            border-radius: 10px;
        }
        
        .certificate-header {
            text-align: center;
            padding-top: 25mm;
            position: relative;
            z-index: 2;
        }
        
        .logo-section {
            margin-bottom: 8mm;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ecac57 0%, #f4d084 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5mm;
        }
        
        .platform-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 2px;
        }
        
        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            margin: 8mm 0;
            letter-spacing: 3px;
        }
        
        .certificate-subtitle {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 10mm;
            font-weight: 300;
        }
        
        .recipient-section {
            text-align: center;
            margin: 10mm 0;
        }
        
        .recipient-label {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 3mm;
            font-weight: 400;
        }
        
        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #944e25;
            margin-bottom: 8mm;
            text-decoration: underline;
            text-decoration-color: #ecac57;
            text-underline-offset: 5px;
        }
        
        .achievement-text {
            font-size: 16px;
            color: #2c3e50;
            line-height: 1.6;
            max-width: 180mm;
            margin: 0 auto 8mm;
            text-align: center;
        }
        
        .bootcamp-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin: 5mm 0;
        }
        
        .completion-date {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 15mm;
        }
        
        .footer-section {
            position: absolute;
            bottom: 25mm;
            left: 25mm;
            right: 25mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        
        .signature-section {
            text-align: center;
            flex: 1;
        }
        
        .signature-line {
            width: 60mm;
            height: 1px;
            background: #bdc3c7;
            margin: 0 auto 3mm;
        }
        
        .signature-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 1mm;
        }
        
        .signature-name {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .qr-section {
            text-align: center;
            flex: 0 0 auto;
            margin-left: 20mm;
        }
        
        .qr-code {
            width: 20mm;
            height: 20mm;
            border: 2px solid #ecac57;
            border-radius: 5px;
            padding: 2mm;
            background: white;
        }
        
        .qr-label {
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 2mm;
        }
        
        .certificate-id {
            position: absolute;
            bottom: 8mm;
            right: 25mm;
            font-size: 10px;
            color: #bdc3c7;
            font-family: 'Courier New', monospace;
        }
        
        .decorative-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .decorative-corner {
            position: absolute;
            width: 40mm;
            height: 40mm;
            background: linear-gradient(45deg, rgba(148, 78, 37, 0.1) 0%, transparent 70%);
        }
        
        .decorative-corner.top-left {
            top: 0;
            left: 0;
            border-radius: 20px 0 0 0;
        }
        
        .decorative-corner.top-right {
            top: 0;
            right: 0;
            border-radius: 0 20px 0 0;
            transform: rotate(90deg);
        }
        
        .decorative-corner.bottom-left {
            bottom: 0;
            left: 0;
            border-radius: 0 0 0 20px;
            transform: rotate(-90deg);
        }
        
        .decorative-corner.bottom-right {
            bottom: 0;
            right: 0;
            border-radius: 0 0 20px 0;
            transform: rotate(180deg);
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(148, 78, 37, 0.03);
            font-weight: 900;
            letter-spacing: 10px;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Decorative Elements -->
        <div class="decorative-elements">
            <div class="decorative-corner top-left"></div>
            <div class="decorative-corner top-right"></div>
            <div class="decorative-corner bottom-left"></div>
            <div class="decorative-corner bottom-right"></div>
            <div class="watermark">LEARNSERVE</div>
        </div>
        
        <!-- Certificate Borders -->
        <div class="certificate-border"></div>
        <div class="certificate-inner-border"></div>
        
        <!-- Certificate Content -->
        <div class="certificate-header">
            <div class="logo-section">
                <div class="logo">LS</div>
                <div class="platform-name">LEARNSERVE</div>
            </div>
            
            <h1 class="certificate-title">CERTIFICATE</h1>
            <p class="certificate-subtitle">of Completion</p>
        </div>
        
        <div class="recipient-section">
            <p class="recipient-label">This is to certify that</p>
            <h2 class="recipient-name">{{ $student_name }}</h2>
            
            <div class="achievement-text">
                has successfully completed all requirements and demonstrated proficiency in the
                <div class="bootcamp-name">{{ $bootcamp_title }}</div>
                bootcamp program with excellence and dedication.
            </div>
            
            <p class="completion-date">
                Completed on {{ \Carbon\Carbon::parse($completion_date)->format('F d, Y') }}
            </p>
        </div>
        
        <!-- Footer with Signature and QR -->
        <div class="footer-section">
            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-label">Instructor</div>
                <div class="signature-name">{{ $instructor_name }}</div>
            </div>
            
            <div class="qr-section">
                @if($qr_code_url)
                    <img src="{{ $qr_code_url }}" alt="QR Code" class="qr-code">
                @else
                    <div class="qr-code" style="display: flex; align-items: center; justify-content: center; font-size: 8px; color: #bdc3c7;">
                        QR CODE
                    </div>
                @endif
                <div class="qr-label">Scan to Verify</div>
            </div>
        </div>
        
        <!-- Certificate ID -->
        <div class="certificate-id">
            Certificate ID: {{ $certificate_id }}
        </div>
    </div>
</body>
</html>