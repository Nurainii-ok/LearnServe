<header>
    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>

        @if(request()->routeIs('admin.dashboard'))
            Admin Dashboard
        @elseif(request()->routeIs('admin.members*'))
            Member
        @elseif(request()->routeIs('admin.tutors*'))
            Tutor
        @elseif(request()->routeIs('admin.classes*'))
            Kelas
        @elseif(request()->routeIs('admin.bootcamp*'))
            Bootcamp
        @elseif(request()->routeIs('admin.payments*'))
            Pembayaran
        @elseif(request()->routeIs('admin.tasks*'))
            Tugas
        @elseif(request()->routeIs('admin.video-contents*'))
            Konten Video
        @elseif(request()->routeIs('admin.enrollment*'))
            Pendaftaran
        @elseif(request()->routeIs('admin.account*'))
            Account Settings
        @else
            {{ __('Admin Panel') }}
        @endif
    </h1>

    <div class="search-wrapper">
        <span class="las la-search"></span>
        <input type="search" placeholder="Search members, tutors, classes..." />
    </div>

    <!-- Back to Website Button -->
    <!--<div class="back-to-website">
        <a href="{{ route('home') }}" class="btn-back-to-website" title="Back to Website">
            <span class="las la-globe"></span>
            <span class="back-text">Back to Website</span>
        </a>
    </div>-->

    <div class="user-wrapper">
        @if(session('user_id'))
            @php
                $currentUser = \App\Models\User::find(session('user_id'));
            @endphp
            @if($currentUser && $currentUser->profile_photo)
                <img 
                    src="{{ asset('storage/profile_photos/' . $currentUser->profile_photo) }}" 
                    width="40" 
                    height="40" 
                    alt="User Avatar"
                    style="border-radius: 50%; object-fit: cover;">
            @else
                <div style="
                    width:40px; 
                    height:40px; 
                    border-radius:50%; 
                    background: var(--primary-brown); 
                    color:#fff; 
                    display:flex; 
                    align-items:center; 
                    justify-content:center; 
                    font-weight:bold;
                ">
                    {{ strtoupper(substr(session('username', 'A'), 0, 1)) }}
                </div>
            @endif

            <div class="user-info">
                <h4>{{ session('username', 'Administrator') }}</h4>
                <small>{{ ucfirst(session('role', 'admin')) }}</small>
            </div>
        @else
            <div style="
                width:40px; 
                height:40px; 
                border-radius:50%; 
                background: var(--primary-brown); 
                color:#fff; 
                display:flex; 
                align-items:center; 
                justify-content:center; 
                font-weight:bold;
            ">
                A
            </div>
            <div class="user-info">
                <h4>Administrator</h4>
                <small>Super Admin</small>
            </div>
        @endif
    </div>
</header>

<style>
/* =======================================
   FIXED HEADER YANG TIDAK BERPINDA-PINDAH
=========================================*/
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 50px;
    background: #FAFAF7;
    position: fixed; /* FIXED supaya tidak gerak */
    top: 0;
    left: 260px; /* LEBAR SIDEBAR */
    width: calc(100% - 260px);
    height: 70px;
    z-index: 200;
    border-bottom: 1px solid #eee;
    transition: 0.3s ease;
}

/* Judul */
header h1 {
    font-size: 20px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

/* Search wrapper */
.search-wrapper {
    display: flex;
    align-items: center;
    background: #f1f1f1;
    padding: 8px 15px;
    border-radius: 30px;
    gap: 5px;
    flex: 1;
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


</style>
