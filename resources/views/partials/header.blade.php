<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/header_footer.css') }}">
</head>
<body>
  <nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">

    @if(request()->routeIs('beli_sekarang'))
      <!-- Header khusus untuk halaman Beli Sekarang -->
      <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
        <img src="{{ asset('assets/Logo.jpg') }}" alt="LearnServe" 
            style="height: 80px; width: auto; margin-right: 8px;">
      </a>

      <div class="ms-auto">
        <a href="{{ route('detail_kursus') }}" class="btn btn-outline-danger fw-semibold">Batal</a>
      </div>

    @else
      <!-- Header normal -->
      <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
        <img src="{{ asset('assets/Logo.jpg') }}" alt="LearnServe" 
            style="height: 80px; width: auto; margin-right: 8px;">
        <span style="color: #944e25;"></span>
      </a>

      <!-- Toggle button (mobile) -->
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link fw-semibold {{ request()->routeIs('home') ? 'active' : 'text-white' }}" 
              href="{{ route('home') }}">
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold {{ request()->routeIs('learning') ? 'active' : 'text-white' }}" 
              href="{{ route('learning') }}">
              E-Learning
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold {{ request()->routeIs('bootcamp') ? 'active' : 'text-white' }}" 
              href="{{ route('bootcamp') }}">
              Bootcamp
            </a>
          </li>
        </ul>

        <!-- Jika belum login -->
        @if(!session()->has('role'))
        <div class="d-flex">
          <a href="{{ route('auth') }}" class="btn btn-outline-light me-2 custom-login-btn">Login</a>
          <a href="{{ route('auth') }}" class="btn btn-warning fw-semibold custom-register-btn">Register</a>
        </div>
        @endif

        <!-- Jika sudah login -->
        @if(session()->has('role'))
        <div class="dropdown">
          <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
            href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

            @if(session('profile_photo'))
              <img src="{{ asset('storage/'.session('profile_photo')) }}" 
                  class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
            @else
              <div class="rounded-circle bg-info d-flex justify-content-center align-items-center" 
                  style="width:40px; height:40px; font-weight:bold; color:white;">
                {{ strtoupper(substr(session('username'),0,1)) }}
              </div>
            @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li class="px-3 py-2">
              <strong>{{ session('username') }}</strong><br>
              <small class="text-muted">{{ session('role') }}</small>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item text-danger">Logout</button>
            </form>
          </ul>
        </div>
        @endif
      </div>
    @endif

  </div>
</nav>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
