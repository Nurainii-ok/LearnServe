<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="{{ url('/') }}">
            LearnServe
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" 
                aria-controls="navbarNav" 
                aria-expanded="false" 
                aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Left Menu -->
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" 
                       href="{{ url('/') }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('learning') ? 'active' : '' }}" 
                       href="{{ url('/learning') }}">
                        Kelas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('bootcamp') ? 'active' : '' }}" 
                       href="{{ url('/bootcamp') }}">
                        Bootcamp
                    </a>
                </li>

                <!--<li class="nav-item">
                    <a class="nav-link {{ request()->is('tentang') ? 'active' : '' }}" 
                       href="{{ url('/tentang') }}">
                        Tentang Kami
                    </a>
                </li>-->

            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav ms-3">

                @guest
                    <!-- Login -->
                    <li class="nav-item">
                        <a class="btn custom-login-btn me-2" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <!-- Register -->
                    <li class="nav-item">
                        <a class="btn custom-register-btn" href="{{ route('auth') }}">
                            Daftar
                        </a>
                    </li>
                @endguest


                @auth
                <!-- DROPDOWN USER -->
            
                <li class="nav-item dropdown">
                    <button class="dropdown-toggle btn" id="userDropdown" 
                            data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.Auth::user()->name }}"
                            alt="avatar"
                            class="rounded-circle me-2"
                            width="32" height="32">

                        {{ Auth::user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">

                        {{-- Jika role admin atau tutor --}}
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'tutor')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                        @endif

                        {{-- Jika role member --}}
                        @if(Auth::user()->role == 'member')
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    Profil Saya
                                </a>
                            </li>
                        @endif

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>


                @endauth

            </ul>
        </div>

    </div>
</nav>
