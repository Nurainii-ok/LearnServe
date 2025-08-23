<header>

    <h1>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>
        @yield('page-title', 'Dashboard')
    </h1>

    <div class="search-wrapper">
        <span class="las la-search"></span>
        <input type="search" placeholder="search here" />
    </div>

<div class="user-wrapper">
    @if(auth()->user()->photo ?? false)
        {{-- Kalau ada foto --}}
        <img 
            src="{{ asset('assets/tuktuk/' . auth()->user()->photo) }}" 
            width="40" 
            height="40" 
            alt="User Avatar"
            style="border-radius: 50%; object-fit: cover;">
    @else
        {{-- Kalau tidak ada foto, pakai inisial --}}
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