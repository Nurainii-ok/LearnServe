<header class="main-header layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme">
    <div class="header-left">
        <a class="layout-menu-toggle nav-link" href="javascript:void(0);">
            <i class="la la-bars fs-3"></i>
        </a>




        <h1 class="page-title">
            @if(request()->routeIs('member.dashboard'))
                <span class=""></span> Dashboard
            @elseif(request()->routeIs('profile'))
                <span class=""></span> Profil
            @elseif(request()->routeIs('member.enrollments*'))
                <span class=""></span> Riwayat Pendaftaran
            @elseif(request()->routeIs('member.task*'))
                <span class=""></span> Tugas
            @elseif(request()->routeIs('elearning*'))
                <span class=""></span> Aktivitas
            @elseif(request()->routeIs('member.members*'))
                <span class=""></span> Member 
            @elseif(request()->routeIs('admin.tutors*'))
                <span class="las la-chalkboard-teacher"></span> Tutor 
            @elseif(request()->routeIs('admin.classes*'))
                <span class="las la-school"></span> Kelas
            @elseif(request()->routeIs('admin.payments*'))
                <span class="las la-credit-card"></span> Pembayaran
            @elseif(request()->routeIs('admin.tasks*'))
                <span class="las la-tasks"></span> Tugas
            @elseif(request()->routeIs('admin.account*'))
                <span class="las la-cog"></span> Account Settings
            
            @else
              Admin Panel
            @endif
        </h1>
    </div>

    <div class="header-center">
        <div class="search-wrapper">
            <span class="las la-search search-icon"></span>
            <input type="search" placeholder="Search members, tutors, classes..." class="search-input" />
        </div>
    </div>

    <div class="header-right">
        <div class="user-wrapper">
            <div class="user-avatar">
                @if(session('user_id'))
                    @php
                        $currentUser = \App\Models\User::find(session('user_id'));
                    @endphp
                    @if($currentUser && $currentUser->profile_photo)
                        <img 
                            src="{{ asset('storage/profile_photos/' . $currentUser->profile_photo) }}" 
                            alt="User Avatar"
                            class="avatar-img">
                    @else
                        <div class="avatar-initial">
                            {{ strtoupper(substr(session('username', 'A'), 0, 1)) }}
                        </div>
                    @endif
                @else
                    <div class="avatar-initial">A</div>
                @endif
            </div>

            <div class="user-info">
                <h4 class="user-name">{{ session('username', 'Administrator') }}</h4>
                <small class="user-role">{{ ucfirst(session('role', 'admin')) }}</small>
            </div>
        </div>
    </div>
</header>

<style>
/* =======================================
   MODERN HEADER STYLES
=========================================*/
.main-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    background: #ffffff;
    position: fixed;
    top: 0;
    left: 260px;
    width: calc(100% - 260px);
    height: 70px;
    z-index: 200;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

/* =======================================
   HEADER LEFT - Title & Menu Toggle
=========================================*/
.header-left {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex: 0 0 auto;
    min-width: 250px;
}

.menu-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    margin: 0;
}

.menu-toggle:hover {
    background: #f3f4f6;
}

.menu-toggle .las {
    font-size: 1.5rem;
    color: #374151;
}

.page-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

.page-title .las {
    font-size: 1.25rem;
    color: #6b7280;
}

/* =======================================
   HEADER CENTER - Search
=========================================*/
.header-center {
    flex: 1;
    display: flex;
    justify-content: center;
    padding: 0 2rem;
    max-width: 600px;
}

.search-wrapper {
    display: flex;
    align-items: center;
    background: #f9fafb;
    padding: 0.625rem 1rem;
    border-radius: 12px;
    gap: 0.75rem;
    width: 100%;
    max-width: 500px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.search-wrapper:focus-within {
    background: #ffffff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-icon {
    font-size: 1.25rem;
    color: #9ca3af;
    transition: color 0.2s ease;
}

.search-wrapper:focus-within .search-icon {
    color: #3b82f6;
}

.search-input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 0.875rem;
    color: #111827;
    font-family: inherit;
}

.search-input::placeholder {
    color: #9ca3af;
}

/* =======================================
   HEADER RIGHT - User Profile
=========================================*/
.header-right {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-wrapper:hover {
    background: #f9fafb;
}

.user-avatar {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

.avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e5e7eb;
}

.avatar-initial {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
    border: 2px solid #e5e7eb;
}

.user-info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #111827;
    margin: 0;
    line-height: 1.2;
}

.user-role {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: capitalize;
    line-height: 1;
}

/* =======================================
   SIDEBAR CLOSED STATE
=========================================*/
.sidebar.closed ~ .main-header {
    left: 70px;
    width: calc(100% - 70px);
}

/* =======================================
   RESPONSIVE BREAKPOINTS
=========================================*/

/* Tablet */
@media (max-width: 1024px) {
    .main-header {
        padding: 0 1.5rem;
    }

    .header-center {
        padding: 0 1rem;
    }

    .page-title {
        font-size: 1rem;
    }

    .user-info {
        display: none;
    }
}

/* Mobile */
@media (max-width: 768px) {
    .main-header {
        left: 0 !important;
        width: 100% !important;
        padding: 0 1rem;
        height: auto;
        min-height: 60px;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .header-left {
        flex: 1;
        min-width: auto;
    }

    .page-title {
        font-size: 0.875rem;
    }

    .page-title .las {
        display: none;
    }

    .header-center {
        order: 3;
        width: 100%;
        padding: 0;
        max-width: none;
        padding-bottom: 0.75rem;
    }

    .search-wrapper {
        max-width: none;
    }

    .header-right {
        flex: 0 0 auto;
    }

    .user-wrapper {
        padding: 0.25rem;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .menu-toggle {
        width: 36px;
        height: 36px;
    }

    .menu-toggle .las {
        font-size: 1.25rem;
    }

    .search-wrapper {
        padding: 0.5rem 0.75rem;
    }

    .search-input {
        font-size: 0.8125rem;
    }
}
</style>