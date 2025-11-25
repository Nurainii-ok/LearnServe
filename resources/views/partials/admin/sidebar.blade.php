<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">
        <img src="{{ asset('assets/LOGO.png') }}" alt="Logo" class="brand-logo">

        <div class="brand-text">
            <span class="brand-title">LearnServe</span>
            <small class="brand-role">Admin</small>
        </div>
    </a>


    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="las la-tachometer-alt"></span>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                    <span class="las la-users"></span>
                    <span>Member</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.tutors') }}" class="{{ request()->routeIs('admin.tutors*') ? 'active' : '' }}">
                    <span class="las la-chalkboard-teacher"></span>
                    <span>Tutor</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.classes') }}" class="{{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                    <span class="las la-graduation-cap"></span>
                    <span>Kelas</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.bootcamps') }}" class="{{ request()->routeIs('admin.bootcamps*') ? 'active' : '' }}">
                    <span class="las la-rocket"></span>
                    <span>Bootcamp</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <span class="las la-credit-card"></span>
                    <span>Pembayaran</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.tasks') }}" class="{{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
                    <span class="las la-clipboard-list"></span>
                    <span>Tugas</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.video-contents.index') }}" class="{{ request()->routeIs('admin.video-contents*') ? 'active' : '' }}">
                    <span class="las la-video"></span>
                    <span>Konten Video</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.enrollments') }}" class="{{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}">
                    <span class="las la-user-check"></span>
                    <span>Pendaftaran</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.account') }}" class="{{ request()->routeIs('admin.account*') ? 'active' : '' }}">
                    <span class="las la-user-circle"></span>
                    <span>Akun</span>
                </a>
            </li>

            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="las la-sign-out-alt"></span>
                    <span>Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

<<style>

    .main-content {
        margin-left: 260px;
        padding-top: 90px; /* supaya konten tidak tertutup header */
        transition: 0.3s ease;
    }

    @media (max-width: 992px) {
        .main-content {
            margin-left: 70px;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            margin-left: 60px;
        }
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;

        background: #FAFAF7; /* putih lembut, bukan #FFFFFF */
        padding: 22px;
        border-right: 1px solid #e8e4df;

        display: flex;
        flex-direction: column;
    }

    /* Brand */
    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        text-decoration: none;
        color: inherit;
    }

    .brand-logo {
        height: 40px;
    }

    .brand-text {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .brand-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #4c4037;
    }

    .brand-role {
        font-size: 0.8rem;
        color: #ECAC57; /* soft gold */
    }

    /* Menu */
    .sidebar-menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-menu ul li {
        margin-bottom: 8px;
    }

    .sidebar-menu ul li a {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 12px 14px;
        border-radius: 8px;
        text-decoration: none;

        color: #4c4037;
        font-weight: 500;
        font-size: 0.95rem;

        transition: 0.25s ease;
    }

    /* Hover → warna F3EFEC */
    .sidebar-menu ul li a:hover {
        background: #F3EFEC;
        color: #3a332e;
    }

    /* Active state → sedikit lebih gelap tapi tetap soft */
    .sidebar-menu ul li a.active {
        background: #EADFD9;
        font-weight: 600;
        color: #3a332e;
    }

    .sidebar-menu span.las {
        font-size: 1.2rem;
    }

    /* ===================== RESPONSIVE SIDEBAR ====================== */
    @media (max-width: 992px) {
        .sidebar {
            width: 85px !important;
            padding: 20px 14px !important;
            transition: 0.3s ease-in-out;
        }

        .brand-logo {
            height: 34px;
        }

        .brand-text {
            display: none !important;
        }

        .sidebar-menu ul li a {
            justify-content: flex-start !important; 
            padding: 14px 10px !important;
            border-radius: 10px;
        }

        .sidebar-menu span.las {
            font-size: 1.45rem !important;
            margin-left: 6px !important; /* beri jarak dari pinggir */
        }

        /* sembunyikan teks menu */
        .sidebar-menu ul li a span:not(.las) {
            display: none !important;
        }

        /* konten bergeser */
        .main-content {
            margin-left: 85px !important;
        }
    }


    /* Extra: layar sangat kecil (mobile) */
    @media (max-width: 576px) {
        .sidebar {
            width: 60px;
            padding: 18px 8px;
        }

        .sidebar-menu span.las {
            font-size: 1.1rem;
        }
    }



    /* =========================================================
    TOGGLE SIDEBAR (LEWAT #nav-toggle)
    ========================================================= */


    /* Sembunyikan brand text saat collapse */
    #nav-toggle:checked ~ .sidebar .brand-text {
        display: none !important;
    }

    /* Sembunyikan menu text (kecuali ikon) */
    #nav-toggle:checked ~ .sidebar .sidebar-menu ul li a span:not(.las) {
        display: none !important;
    }

    /* Menu rata tengah */
    #nav-toggle:checked ~ .sidebar .sidebar-menu ul li a {
        justify-content: center !important;
    }
</style>


