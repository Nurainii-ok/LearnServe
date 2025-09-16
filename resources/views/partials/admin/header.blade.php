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
