<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Not Found - LearnServe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #944e25 0%, #6b3419 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-container {
            max-width: 500px;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .error-icon {
            width: 100px;
            height: 100px;
            background: #dc3545;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 3rem;
        }
        
        .error-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .btn-home {
            background: linear-gradient(135deg, #ecac57 0%, #f4d084 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.2s ease;
            box-shadow: 0 5px 15px rgba(148, 78, 37, 0.3);
        }
        
        .btn-home:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="las la-exclamation-triangle"></i>
        </div>
        
        <h1 class="error-title">Certificate Not Found</h1>
        
        <p class="error-message">
            The certificate you're looking for could not be found or may have been revoked. 
            Please check the certificate ID and try again, or contact the issuing institution for assistance.
        </p>
        
        <a href="{{ route('home') }}" class="btn-home">
            <i class="las la-home"></i> Back to Home
        </a>
    </div>
</body>
</html>