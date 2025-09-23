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
