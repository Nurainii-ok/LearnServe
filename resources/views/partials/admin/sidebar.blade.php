<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">
        <img src="{{ asset('assets/LOGO.png') }}" alt="Logo" class="brand-logo">

        <div class="brand-text">
            <span class="brand-title">LearnServe</span>
            <small class="brand-role">Admin</small>
        </div>
    </a>


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
                <a href="{{ route('admin.bootcamps') }}" class="{{ request()->routeIs('admin.bootcamps*') ? 'active' : '' }}">
                    <span class="las la-rocket"></span>
                    <span>Bootcamp</span>
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
                <a href="{{ route('admin.video-contents.index') }}" class="{{ request()->routeIs('admin.video-contents*') ? 'active' : '' }}">
                    <span class="las la-video"></span>
                    <span>Video Contents</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.enrollments') }}" class="{{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}">
                    <span class="las la-user-check"></span>
                    <span>Enrollments</span>
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

<style>
    /* Sidebar */
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;

        background: #FAFAF7; /* putih lembut, bukan #FFFFFF */
        padding: 22px;
        border-right: 1px solid #e8e4df;

        display: flex;
        flex-direction: column;
    }

    /* Brand */
    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        text-decoration: none;
        color: inherit;
    }

    .brand-logo {
        height: 40px;
    }

    .brand-text {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .brand-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #4c4037;
    }

    .brand-role {
        font-size: 0.8rem;
        color: #ECAC57; /* soft gold */
    }

    /* Menu */
    .sidebar-menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-menu ul li {
        margin-bottom: 8px;
    }

    .sidebar-menu ul li a {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 12px 14px;
        border-radius: 8px;
        text-decoration: none;

        color: #4c4037;
        font-weight: 500;
        font-size: 0.95rem;

        transition: 0.25s ease;
    }

    /* Hover → warna F3EFEC */
    .sidebar-menu ul li a:hover {
        background: #F3EFEC;
        color: #3a332e;
    }

    /* Active state → sedikit lebih gelap tapi tetap soft */
    .sidebar-menu ul li a.active {
        background: #EADFD9;
        font-weight: 600;
        color: #3a332e;
    }

    .sidebar-menu span.las {
        font-size: 1.2rem;
    }
</style>
