<!-- Header -->
<!--<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
     id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">-->
    <!-- Search -->
    <!--<div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="bx bx-search fs-4 lh-0"></i>
        <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
      </div>
    </div>-->
    <!-- /Search -->
    
    <!-- Back to Website Button -->
    <!--<div class="me-3">
      <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1" title="Back to Website">
        <i class="bx bx-globe"></i>
        <span class="d-none d-md-inline">Back to Website</span>
      </a>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto">-->

      <!-- User -->
      <!--<li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            @if(session('profile_photo'))
              <img src="{{ asset('storage/'.session('profile_photo')) }}" alt class="w-px-40 h-auto rounded-circle" />
            @else
              <div class="avatar-initial rounded-circle" style="background-color: var(--primary-gold); color: white; font-weight: 600;">
                {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
              </div>
            @endif
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    @if(session('profile_photo'))
                      <img src="{{ asset('storage/'.session('profile_photo')) }}" alt class="w-px-40 h-auto rounded-circle" />
                    @else
                      <div class="avatar-initial rounded-circle" style="background-color: var(--primary-gold); color: white; font-weight: 600;">
                        {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
                      </div>
                    @endif
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">{{ session('username', 'Member') }}</span>
                  <small class="text-muted">Member</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('profile') }}">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
              @csrf
              <button type="submit" class="dropdown-item border-0 bg-transparent w-100 text-start">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </button>
            </form>
          </li>
        </ul>
      </li>-->
      <!--/ User -->
    <!--</ul>
  </div>
</nav>-->

<header>
    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>

        @if(request()->routeIs('admin.dashboard'))
            Admin Dashboard
        @elseif(request()->routeIs('admin.members*'))
            Member Management
        @elseif(request()->routeIs('admin.tutors*'))
            Tutor Management
        @elseif(request()->routeIs('admin.classes*'))
            Class Management
        @elseif(request()->routeIs('admin.payments*'))
            Payment Management
        @elseif(request()->routeIs('admin.tasks*'))
            Task Management
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

