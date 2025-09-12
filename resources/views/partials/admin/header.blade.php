<header>

    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>

        @if(request()->routeIs('admin.dashboard'))
            Dashboard
        @elseif(request()->routeIs('admin.members*'))
            Member
        @elseif(request()->routeIs('admin.tutors*'))
            Tutor
        @elseif(request()->routeIs('admin.classes*'))
            Kelas
        @elseif(request()->routeIs('admin.payments*'))
            Pembayaran
        @elseif(request()->routeIs('admin.tasks*'))
            Tasks
        @elseif(request()->routeIs('admin.account*'))
            Account
        @else
            {{ __('Page') }}
        @endif
    </h1>

    <div class="search-wrapper">
        <span class="las la-search"></span>
        <input type="search" placeholder="search here" />
    </div>

    <div class="user-wrapper">
        @if(auth()->user()->photo ?? false)
            <img 
                src="{{ asset('assets/tuktuk/' . auth()->user()->photo) }}" 
                width="40" 
                height="40" 
                alt="User Avatar"
                style="border-radius: 50%; object-fit: cover;">
        @else
            <div style="
                width:40px; 
                height:40px; 
                border-radius:50%; 
                background:#7494ec; 
                color:#fff; 
                display:flex; 
                align-items:center; 
                justify-content:center; 
                font-weight:bold;
            ">
                {{ strtoupper(substr(auth()->user()->name ?? 'N', 0, 1)) }}
            </div>
        @endif

        <div class="user-info">
            <h4>{{ auth()->user()->name ?? 'Nuraini' }}</h4>
            <small>{{ auth()->user()->role ?? 'Super admin' }}</small>
        </div>
    </div>

</header>
