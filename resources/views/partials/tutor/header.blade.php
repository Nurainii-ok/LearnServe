@section('styles')
  <link rel="stylesheet" href="{{ asset('css/tutor_sidebarHeader.css') }}">
@endsection

<header>
    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>

        @if(request()->routeIs('tutor.dashboard'))
            Tutor Dashboard
        @elseif(request()->routeIs('tutor.classes*'))
            My Classes
        @elseif(request()->routeIs('tutor.bootcamps*'))
            My Bootcamps
        @elseif(request()->routeIs('tutor.tasks*'))
            Tasks & Assignments
        @elseif(request()->routeIs('tutor.video-contents*'))
            Video Contents
        @elseif(request()->routeIs('tutor.account*'))
            Profile & Settings
        @else
            {{ __('Tutor Panel') }}
        @endif
    </h1>

    <div class="header-right">
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="search" placeholder="Search students, classes..." />
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
                    background: var(--primary-gold); 
                    color:#fff; 
                    display:flex; 
                    align-items:center; 
                    justify-content:center; 
                    font-weight:bold;
                ">
                    {{ strtoupper(substr(session('username', 'T'), 0, 1)) }}
                </div>
            @endif

            <div class="user-info">
                <h4>{{ session('username', 'Tutor') }}</h4>
                <small>{{ ucfirst(session('role', 'tutor')) }}</small>
            </div>
        @else
            <div style="
                width:40px; 
                height:40px; 
                border-radius:50%; 
                background: var(--primary-gold); 
                color:#fff; 
                display:flex; 
                align-items:center; 
                justify-content:center; 
                font-weight:bold;
            ">
                T
            </div>
            <div class="user-info">
                <h4>Tutor</h4>
                <small>Instructor</small>
            </div>
        @endif
        </div>
    </div>
</header>

<style>
/* CSS Variables */
:root {
    --primary-gold: #ecac57;
    --primary-brown: #944e25;
    --white: #ffffff;
    --text-primary: #2c2c2c;
    --border-color: #e0e0e0;
}

/* Fix header alignment untuk tutor dashboard - sesuaikan dengan layout Bootstrap */
header {
    background: var(--white);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 100;
    border-bottom: 1px solid var(--border-color);
    width: 100%;
    height: 80px; /* Fixed height for consistent alignment */
}

header h1 {
    color: var(--text-primary);
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
}

header h1 label {
    margin-right: 1rem;
    display: none; /* Hide hamburger on desktop since we're using Bootstrap layout */
}

header h1 label span {
    font-size: 1.5rem;
    color: var(--primary-brown);
    cursor: pointer;
}

/* Show hamburger only on mobile */
@media only screen and (max-width: 1199px) {
    header h1 label {
        display: block;
    }
}

/* Ensure proper spacing for content */
.container-xxl.flex-grow-1.container-p-y {
    padding-left: 1.5rem !important;
    padding-right: 1.5rem !important;
}

/* Fix dashboard content alignment */
.dashboard-content {
    padding-left: 0 !important;
    margin-left: 0 !important;
}

/* Header right section - proper alignment */
.header-right {
    display: flex;
    align-items: center;
    gap: 2.5rem; /* Increased gap for better spacing */
    height: 100%;
}

/* Search wrapper styling */
.search-wrapper {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    width: 300px; /* Fixed width instead of min-width */
    height: 40px;
}

.search-wrapper span {
    color: #6c757d;
    margin-right: 0.5rem;
    font-size: 1rem;
}

.search-wrapper input {
    border: none;
    background: transparent;
    outline: none;
    flex: 1;
    font-size: 0.875rem;
    color: #495057;
}

.search-wrapper input::placeholder {
    color: #6c757d;
}

/* Back to website button */
.back-to-website {
    display: flex;
    align-items: center;
}

.btn-back-to-website {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem; /* Slightly wider padding */
    background: #ecac57;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    height: 40px;
    white-space: nowrap;
    min-width: 140px; /* Minimum width for consistency */
}

.btn-back-to-website:hover {
    background: #944e25;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

/* User wrapper */
.user-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    height: 40px;
    min-width: 120px; /* Minimum width for user section */
}

.user-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.user-info h4 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #495057;
    line-height: 1.2;
}

.user-info small {
    color: #6c757d;
    font-size: 0.75rem;
    line-height: 1;
}

/* Responsive adjustments */
@media only screen and (max-width: 768px) {
    .search-wrapper {
        display: none;
    }
    
    .back-text {
        display: none;
    }
    
    .user-info {
        display: none;
    }
    
    .header-right {
        gap: 0.5rem;
    }
}

@media only screen and (max-width: 480px) {
    .btn-back-to-website {
        padding: 0.5rem;
        min-width: 40px;
        justify-content: center;
    }
}
</style>
