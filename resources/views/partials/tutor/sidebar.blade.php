<div class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('assets/Logo2.png') }}" alt="Logo" style="height:40px; margin-right:10px;">
        <span>LearnServe</span>
        <small style="color: var(--soft-gold); font-size: 0.8rem; margin-left: 0.5rem;">Tutor</small>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('tutor.dashboard') }}" class="{{ request()->routeIs('tutor.dashboard') ? 'active' : '' }}">
                    <span class="las la-tachometer-alt"></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tutor.classes') }}" class="{{ request()->routeIs('tutor.classes*') ? 'active' : '' }}">
                    <span class="las la-chalkboard-teacher"></span>
                    <span>My Classes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tutor.tasks') }}" class="{{ request()->routeIs('tutor.tasks*') ? 'active' : '' }}">
                    <span class="las la-clipboard-check"></span>
                    <span>Tasks & Assignments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tutor.account') }}" class="{{ request()->routeIs('tutor.account*') ? 'active' : '' }}">
                    <span class="las la-user-circle"></span>
                    <span>Profile & Settings</span>
                </a>
            </li>   
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="las la-sign-out-alt"></span>
                    <span>Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>