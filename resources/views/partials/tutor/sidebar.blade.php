<div class="sidebar">
    <div class="sidebar-brand">
        <h1>
            <span class="las la-graduation-cap"></span>
            <span>LearnServe</span>
        </h1>
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
                <a href="{{ route('tutor.bootcamps') }}" class="{{ request()->routeIs('tutor.bootcamps*') ? 'active' : '' }}">
                    <span class="las la-graduation-cap"></span>
                    <span>My Bootcamps</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tutor.tasks') }}" class="{{ request()->routeIs('tutor.tasks*') ? 'active' : '' }}">
                    <span class="las la-clipboard-check"></span>
                    <span>Tasks & Assignments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tutor.video-contents.index') }}" class="{{ request()->routeIs('tutor.video-contents*') ? 'active' : '' }}">
                    <span class="las la-video"></span>
                    <span>Video Contents</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tutor.account') }}" class="{{ request()->routeIs('tutor.account*') ? 'active' : '' }}">
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
