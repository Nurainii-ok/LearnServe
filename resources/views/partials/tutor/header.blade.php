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
</header>


<style>
    /* Fix header alignment untuk tutor dashboard - sesuaikan dengan layout Bootstrap */
header {
    background: var(--white);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 100;
    border-bottom: 1px solid var(--border-color);
    width: 100%;
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
</style>



