<div class="sidebar">
    <div class="sidebar-brand">
        <h1><span class="la la-graduation-cap"></span><span>LearnServe</span></h1>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="las la-igloo"></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                    <span class="las la-users"></span>
                    <span>Member</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tutors') }}" class="{{ request()->routeIs('admin.tutors*') ? 'active' : '' }}">
                    <span class="las la-clipboard-list"></span>
                    <span>Tutor</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.classes') }}" class="{{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                    <span class="las la-shopping-bag"></span>
                    <span>Kelas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <span class="las la-receipt"></span>
                    <span>Pembayaran</span>
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
                <a href="{{ route('admin.account') }}" class="{{ request()->routeIs('admin.account*') ? 'active' : '' }}">
                    <span class="las la-sign-out-alt"></span>
                    <span>Logout</span>
                </a>
            </li>   
        </ul>
    </div>
</div>