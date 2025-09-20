<!-- resources/views/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <!-- Back to Website Button -->
    <div class="back-to-website-auth">
        <a href="{{ route('home') }}" class="btn-back-to-website-auth" title="Back to Website">
            <i class='bx bx-globe'></i>
            <span>Back to Website</span>
        </a>
    </div>
    
    <!-- Logo di pojok -->
    <!--<img src="{{ asset('assets/Logo.jpg') }}" alt="Logo" class="auth-logo">-->

    <div class="container">
        <!-- Login -->
        <div class="form-box login">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username / Email" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                @if(session('error'))
                    <p style="color:red">{{ session('error') }}</p>
                @endif
                <button type="submit" class="btn">Login</button>
            </form>
        </div>

        <!-- Register -->
        <div class="form-box register">
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
                    <i class='bx bxs-user'></i>
                </div>
                @error('username')
                    <p style="color:red; font-size: 0.8rem; margin: -5px 0 10px 0;">{{ $message }}</p>
                @enderror
                
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email / Gmail" value="{{ old('email') }}" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                @error('email')
                    <p style="color:red; font-size: 0.8rem; margin: -5px 0 10px 0;">{{ $message }}</p>
                @enderror
                
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                @error('password')
                    <p style="color:red; font-size: 0.8rem; margin: -5px 0 10px 0;">{{ $message }}</p>
                @enderror
                
                <div class="input-box">
                    <label>Pilih Role:</label><br>
                    <select name="role" required>
                        <!--<option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>-->
                        <option value="tutor" {{ old('role') == 'tutor' ? 'selected' : '' }}>Tutor</option>
                        <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                    </select>
                </div>
                @error('role')
                    <p style="color:red; font-size: 0.8rem; margin: -5px 0 10px 0;">{{ $message }}</p>
                @enderror
                
                @if(session('error'))
                    <p style="color:red; font-size: 0.9rem; margin: 10px 0;">{{ session('error') }}</p>
                @endif
                @if(session('success'))
                    <p style="color:green; font-size: 0.9rem; margin: 10px 0;">{{ session('success') }}</p>
                @endif
                
                <button type="submit" class="btn">Register</button>
            </form>
        </div>

        <!-- Toggle Box -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>

    <script>
    const container = document.querySelector('.container');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');

    registerBtn.addEventListener('click', () => {
        container.classList.add('active');
    });
    loginBtn.addEventListener('click', () => {
        container.classList.remove('active');
    });

    // Cek apakah ada query ?tab=register
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'register') {
        container.classList.add('active'); // langsung buka form register
    }
</script>

</body>
</html>
