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
        <img src="https://via.placeholder.com/40x40/ddd/666?text={{ substr(auth()->user()->name ?? 'N', 0, 1) }}" width="40" height="40" alt="User Avatar">
        <div class="user-info">
            <h4>{{ auth()->user()->name ?? 'Nuraini' }}</h4>
            <small>{{ auth()->user()->role ?? 'Super admin' }}</small>
        </div>
    </div>
</header>