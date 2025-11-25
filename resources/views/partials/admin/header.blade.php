<header>
    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>

        {{-- Dynamic Page Title --}}
        @switch(true)
            @case(request()->routeIs('admin.dashboard'))
                Admin Dashboard
                @break
            @case(request()->routeIs('admin.members*'))
                Member
                @break
            @case(request()->routeIs('admin.tutors*'))
                Tutor
                @break
            @case(request()->routeIs('admin.classes*'))
                Kelas
                @break
            @case(request()->routeIs('admin.bootcamp*'))
                Bootcamp
                @break
            @case(request()->routeIs('admin.payments*'))
                Pembayaran
                @break
            @case(request()->routeIs('admin.tasks*'))
                Tugas
                @break
            @case(request()->routeIs('admin.video-contents*'))
                Konten Video
                @break
            @case(request()->routeIs('admin.enrollment*'))
                Pendaftaran
                @break
            @case(request()->routeIs('admin.account*'))
                Account Settings
                @break
            @default
                {{ __('Admin Panel') }}
        @endswitch
    </h1>

    {{-- Search Bar --}}
    <div class="search-wrapper">
        <span class="las la-search"></span>
        <input type="search" placeholder="Search members, tutors, classes..." />
    </div>

    {{-- User Info --}}
    <div class="user-wrapper">
        @php
            $currentUser = session('user_id') ? \App\Models\User::find(session('user_id')) : null;
        @endphp

        {{-- Avatar --}}
        @if($currentUser && $currentUser->profile_photo)
            <img 
                src="{{ asset('storage/profile_photos/' . $currentUser->profile_photo) }}" 
                width="40" height="40"
                alt="User Avatar"
                style="border-radius: 50%; object-fit: cover;">
        @else
            <div style="
                width:40px; height:40px; border-radius:50%;
                background: var(--primary-brown); color:#fff;
                display:flex; align-items:center; justify-content:center;
                font-weight:bold;
            ">
                {{ strtoupper(substr(session('username', 'A'), 0, 1)) }}
            </div>
        @endif

        {{-- User Name + Role --}}
        <div class="user-info">
            <h4>{{ session('username', 'Administrator') }}</h4>
            <small>{{ ucfirst(session('role', 'admin')) }}</small>
        </div>
    </div>
</header>

<style>
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 50px;
    background: #FAFAF7;
    position: fixed;
    top: 0;
    left: 250px; /* default width */
    width: calc(100% - 250px);
    height: 70px;
    z-index: 200;
    border-bottom: 1px solid #eee;
    transition: 0.3s ease;
}


@media (max-width: 992px) {
    header {
        left: 70px;
        width: calc(100% - 70px);
        padding: 15px 20px;
    }
}

@media (max-width: 576px) {
    header {
        left: 60px;
        width: calc(100% - 60px);
    }
}


/* Judul */
header h1 {
    font-size: 20px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    flex: unset;
}

/* Search wrapper */
.search-wrapper {
    display: flex;
    align-items: center;
    background: #f1f1f1;
    padding: 8px 15px;
    border-radius: 30px;
    gap: 5px;
    flex: unset;
    max-width: 350px;
}

.search-wrapper input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
}

/* User wrapper */
.user-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ================================
   Sidebar tertutup (mobile / toggle)
================================*/
.sidebar.closed + header {
    left: 70px;
    width: calc(100% - 70px);
}

/* ================================
   MOBILE BREAKPOINT
================================*/
@media (max-width: 768px) {
    header {
        left: 0 !important;
        width: 100% !important;
        height: auto;
        flex-wrap: wrap;
        gap: 10px;
    }

    .search-wrapper {
        width: 100%;
        max-width: none;
    }

    .user-wrapper {
        width: 100%;
        justify-content: flex-start;
    }
}

/* =========================================================
   TOGGLE SIDEBAR (LEWAT #nav-toggle)
   ========================================================= */

/* Jika sidebar ditutup */
#nav-toggle:checked ~ .sidebar {
    width: 70px !important;
    padding: 20px 10px !important;
}

/* Header ikut menyesuaikan */
#nav-toggle:checked ~ .main-content header {
    left: 70px !important;
    width: calc(100% - 70px) !important;
}

/* Main content bergeser */
#nav-toggle:checked ~ .main-content {
    margin-left: 70px !important;
}

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
