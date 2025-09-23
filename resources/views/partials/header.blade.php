<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">

    @if(request()->routeIs('checkout'))
      <!-- Header khusus untuk halaman Beli Sekarang -->
      <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
        <img src="{{ asset('assets/Logo.jpg') }}" alt="LearnServe" 
            style="height: 80px; width: auto; margin-right: 8px;">
      </a>

      <div class="ms-auto">
        @if(!empty($class))
          <a href="{{ route('detail_kursus', ['id' => $class->id]) }}" class="btn btn-outline-danger fw-semibold">Batal</a>
        @elseif(!empty($bootcamp))
          <a href="{{ route('deskripsi_bootcamp', ['id' => $bootcamp->id]) }}" class="btn btn-outline-danger fw-semibold">Batal</a>
        @endif
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
          <a href="{{ route('auth') }}?tab=register" class="btn btn-warning fw-semibold custom-register-btn">Register</a>
        </div>
        @endif

        <!-- Jika sudah login -->
        @if(session()->has('role'))
        <div class="dropdown">
          <button class="btn d-flex align-items-center text-white text-decoration-none dropdown-toggle border-0 bg-transparent p-2" 
            type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" 
            style="cursor: pointer; background: transparent !important; border: none !important;">

            @if(session('profile_photo'))
              <img src="{{ asset('storage/'.session('profile_photo')) }}" 
                  class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
            @else
              <div class="rounded-circle bg-info d-flex justify-content-center align-items-center" 
                  style="width:40px; height:40px; font-weight:bold; color:white;">
                {{ strtoupper(substr(session('username'),0,1)) }}
              </div>
            @endif
            
            <span class="ms-2">{{ session('username') }}</span>
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li class="px-3 py-2">
              <strong>{{ session('username') }}</strong><br>
              <small class="text-muted">{{ session('role') }}</small>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              @if(session('role') === 'admin')
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
              @elseif(session('role') === 'tutor')
                <a class="dropdown-item" href="{{ route('tutor.dashboard') }}">Dashboard</a>
              @else
                <a class="dropdown-item" href="{{ route('profile') }}">Profil</a>
              @endif
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
              </form>
            </li>
          </ul>
        </div>
        @endif
      </div>
    @endif

  </div>
</nav>
