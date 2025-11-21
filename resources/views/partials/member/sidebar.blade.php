<aside class="sidebar">

    <!-- BRAND -->
    <a href="{{ route('home') }}" class="sidebar-brand">
        <img src="{{ asset('assets/LOGO.png') }}" alt="Logo" class="brand-logo">

        <div class="brand-text">
            <span class="brand-title">LearnServe</span>
            <small class="brand-role">Member</small>
        </div>
    </a>

    <!-- MENU -->
    <div class="sidebar-menu">
        <ul>

            <li>
                <a href="{{ route('member.dashboard') }}" class="{{ request()->routeIs('member.dashboard*') ? 'active' : '' }}">
                    <span class="las la-home"></span>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile*') ? 'active' : '' }}">
                    <span class="las la-user"></span>
                    <span>Profile</span>
                </a>
            </li>

            <li>
                <a href="{{ route('member.enrollments') }}" class="{{ request()->routeIs('member.enrollments*') ? 'active' : '' }}">
                    <span class="las la-book"></span>
                    <span>My Enrollments</span>
                </a>
            </li>

            <li>
                <a href="{{ route('member.grades') }}" class="{{ request()->routeIs('member.grades*') ? 'active' : '' }}">
                    <span class="las la-medal"></span>
                    <span>My Grades</span>
                </a>
            </li>

            <li>
                <a href="{{ route('member.tasks') }}" class="{{ request()->routeIs('member.tasks*') ? 'active' : '' }}">
                    <span class="las la-clipboard-list"></span>
                    <span>My Tasks</span>
                </a>
            </li>

            <li>
                <a href="{{ route('elearning.index') }}" class="{{ request()->routeIs('elearning*') ? 'active' : '' }}">
                    <span class="las la-play-circle"></span>
                    <span>E-Learning</span>
                </a>
            </li>

            <li>
                <a href="{{ route('learning') }}">
                    <span class="las la-book-open"></span>
                    <span>Explore Learning</span>
                </a>
            </li>

            <li>
                <a href="{{ route('bootcamp') }}">
                    <span class="las la-rocket"></span>
                    <span>Bootcamp</span>
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

</aside>

<style>
  .sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;

    background: #FAFAF7;
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
    color: #ECAC57;
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

/* Hover */
.sidebar-menu ul li a:hover {
    background: #F3EFEC;
    color: #3a332e;
}

/* Active */
.sidebar-menu ul li a.active {
    background: #EADFD9;
    font-weight: 600;
    color: #3a332e;
}

.sidebar-menu span.las {
    font-size: 1.2rem;
}

</style>