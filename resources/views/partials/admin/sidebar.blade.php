<div class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('assets/Logo2.png') }}" alt="Logo" style="height:40px; margin-right:10px;">
        <span>LearnServe</span>
        <small style="color: var(--soft-gold); font-size: 0.8rem; margin-left: 0.5rem;">Admin</small>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="las la-tachometer-alt"></span>
                    <span>Dashboard</span>
                </a>
            </li>
             <li>
                <a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                    <span class="las la-users"></span>
                    <span>Members</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tutors') }}" class="{{ request()->routeIs('admin.tutors*') ? 'active' : '' }}">
                    <span class="las la-chalkboard-teacher"></span>
                    <span>Tutors</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.classes') }}" class="{{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                    <span class="las la-graduation-cap"></span>
                    <span>Classes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <span class="las la-credit-card"></span>
                    <span>Payments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tasks') }}" class="{{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
                    <span class="las la-clipboard-list"></span>
                    <span>Tasks</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.account') }}" class="{{ request()->routeIs('admin.account*') ? 'active' : '' }}">
                    <span class="las la-user-circle"></span>
                    <span>Account</span>
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