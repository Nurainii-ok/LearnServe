<header>
    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>

        @if(request()->routeIs('tutor.dashboard'))
            Tutor Dashboard
        @elseif(request()->routeIs('tutor.classes*'))
            My Classes
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
        <div class="back-to-website">
            <a href="{{ route('home') }}" class="btn-back-to-website" title="Back to Website">
                <span class="las la-globe"></span>
                <span class="back-text">Back to Website</span>
            </a>
        </div>

        <div class="user-wrapper">
        @if(session('user_id'))
            @php
                $currentUser = \App\Models\User::find(session('user_id'));
            @endphp
            @if($currentUser && $currentUser->photo ?? false)
                <img 
                    src="{{ asset('assets/tuktuk/' . $currentUser->photo) }}" 
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
/* CSS Variables untuk konsistensi */
:root {
    --primary-gold: #ecac57;
    --primary-brown: #944e25;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --text-primary: #2c2c2c;
    --text-secondary: #666666;
    --background-light: #f8f8f8;
    --white: #ffffff;
    --light-gray: #e5e5e5;
    --border-color: #e0e0e0;
}

/* Fix header alignment untuk tutor dashboard - sesuaikan dengan layout Bootstrap */
header {
    background: var(--white);
    display: flex;
    justify-content: flex-start; /* Changed from space-between to flex-start */
    align-items: center;
    padding: 1.25rem 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 99;
    border-bottom: 1px solid var(--border-color);
    width: calc(100vw - 280px); /* Full viewport width minus sidebar */
    margin-left: -280px; /* Offset untuk sidebar width */
    padding-left: calc(35px + 0.5rem); /* Minimal padding - sangat mepet ke sidebar */
    padding-right: 2rem;
    left: 280px; /* Position dari kanan sidebar */
}

header h1 {
    color: var(--text-primary);
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
    margin-right: auto; /* Push other elements to the right */
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
    
    header {
        width: 100vw;
        margin-left: 0;
        padding-left: 0.5rem; /* Consistent dengan desktop spacing */
        left: 0;
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

/* Override sidebar z-index to be above header */
.sidebar {
    z-index: 101 !important;
}

/* Search wrapper styling */
.search-wrapper {
    border: 1px solid var(--light-gray);
    border-radius: 12px;
    height: 45px;
    display: flex;
    align-items: center;
    overflow: hidden;
    width: 280px; /* Fixed width instead of flex */
    background: var(--background-light);
}

.search-wrapper span {
    display: inline-block;
    padding: 0 1rem;
    font-size: 1.2rem;
    color: var(--text-secondary);
}

.search-wrapper input {
    border: none;
    outline: none;
    background: transparent;
    height: 100%;
    padding: 0 1rem 0 0;
    font-size: 0.9rem;
    color: var(--text-primary);
    width: 100%;
}

/* Header right section - group search, back button, and user info */
.header-right {
    display: flex;
    align-items: center;
    gap: 5.2rem;
}

/* Back to website button */
.back-to-website {
    margin-right: 0; /* Remove margin since we use gap in parent */
}

.btn-back-to-website {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--primary-gold);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back-to-website:hover {
    background: var(--primary-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

/* User wrapper */
.user-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-info h4 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
}

.user-info small {
    color: var(--text-secondary);
    font-size: 0.75rem;
}

/* Content wrapper adjustments */
.content-wrapper {
    padding-top: 0 !important;
}

.container-xxl.flex-grow-1.container-p-y {
    padding-top: 1.5rem !important;
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
    
    header {
        padding: 1rem 1.5rem;
    }
}

@media only screen and (max-width: 480px) {
    header {
        padding: 0.75rem 1rem;
    }
    
    header h1 {
        font-size: 1rem;
    }
}
</style>
