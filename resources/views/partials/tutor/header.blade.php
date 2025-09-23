<header class="tutor-header-fixed">
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
</header>

<style>
/* Fix header height and ensure it matches admin */
.tutor-header-fixed {
    background: var(--white);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 2rem !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 100;
    border-bottom: 1px solid var(--border-color);
    height: 80px !important; /* Fixed height same as admin */
    min-height: 80px !important;
    max-height: 80px !important;
}

/* Ensure all elements fit within the fixed height */
.tutor-header-fixed h1 {
    color: var(--text-primary);
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 1.1rem !important;
    margin: 0;
    line-height: 1.2;
}

.tutor-header-fixed label span {
    font-size: 1.5rem;
    padding-right: 1rem;
    color: var(--primary-brown);
    cursor: pointer;
}

.tutor-header-fixed .search-wrapper {
    border: 1px solid var(--light-gray);
    border-radius: 12px;
    height: 45px !important;
    display: flex;
    align-items: center;
    overflow: hidden;
    flex: 1;
    max-width: 320px;
    margin: 0 2rem;
    background: var(--background-light);
}

.tutor-header-fixed .search-wrapper span {
    display: inline-block;
    padding: 0 1rem;
    font-size: 1.2rem;
    color: var(--text-secondary);
}

.tutor-header-fixed .search-wrapper input {
    height: 100%;
    padding: 0.5rem;
    border: none;
    outline: none;
    flex: 1;
    background: transparent;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.tutor-header-fixed .search-wrapper input::placeholder {
    color: var(--text-secondary);
}

.tutor-header-fixed .user-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.tutor-header-fixed .user-wrapper img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--light-cream);
    border: 2px solid var(--soft-gold);
}

.tutor-header-fixed .user-info h4 {
    font-size: 0.9rem;
    color: var(--text-primary);
    font-weight: 600;
    margin: 0;
    line-height: 1.2;
}

.tutor-header-fixed .user-info small {
    color: var(--text-secondary);
    font-size: 0.8rem;
    line-height: 1;
}

/* Back to website button styling */
.tutor-header-fixed .btn-back-to-website {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    background: var(--primary-brown);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    height: 36px; /* Fixed height to fit in header */
}

.tutor-header-fixed .btn-back-to-website:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
}

.tutor-header-fixed .btn-back-to-website span:first-child {
    font-size: 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .tutor-header-fixed {
        padding: 1rem !important;
        height: auto !important;
        min-height: 60px !important;
        max-height: none !important;
    }
    
    .tutor-header-fixed .search-wrapper {
        max-width: 200px;
        margin: 0 1rem;
    }
    
    .tutor-header-fixed .back-text {
        display: none;
    }
    
    .tutor-header-fixed .user-info {
        display: none;
    }
}
</style>