@php
    $user = auth()->user();
    $role = $user?->role ?? '';
@endphp


<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<aside class="sidebar">

    <!-- BRAND -->
    <a href="{{ route('home') }}" class="sidebar-brand">
        <img src="{{ asset('assets/LOGO.png') }}" class="brand-logo">

        <div class="brand-text">
            <span class="brand-title">LearnServe</span>
            <small class="brand-role">{{ ucfirst($role) }}</small>
        </div>
    </a>

    <div class="sidebar-menu">
        <ul>

            {{-- ================= ADMIN ================= --}}
            @if($role === 'admin')
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="las la-tachometer-alt"></span><span>Dashboard</span></a></li>
                <li><a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members*') ? 'active' : '' }}"><span class="las la-users"></span><span>Member</span></a></li>
                <li><a href="{{ route('admin.tutors') }}" class="{{ request()->routeIs('admin.tutors*') ? 'active' : '' }}"><span class="las la-chalkboard-teacher"></span><span>Tutor</span></a></li>
                <li><a href="{{ route('admin.classes') }}" class="{{ request()->routeIs('admin.classes*') ? 'active' : '' }}"><span class="las la-graduation-cap"></span><span>Kelas</span></a></li>
                <li><a href="{{ route('admin.bootcamps') }}" class="{{ request()->routeIs('admin.bootcamps*') ? 'active' : '' }}"><span class="las la-rocket"></span><span>Bootcamp</span></a></li>
                <li><a href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}"><span class="las la-credit-card"></span><span>Pembayaran</span></a></li>
                <li><a href="{{ route('admin.tasks') }}" class="{{ request()->routeIs('admin.tasks*') ? 'active' : '' }}"><span class="las la-clipboard-list"></span><span>Tugas</span></a></li>
                <li><a href="{{ route('admin.video-contents.index') }}" class="{{ request()->routeIs('admin.video-contents*') ? 'active' : '' }}"><span class="las la-video"></span><span>Konten Video</span></a></li>
                <li><a href="{{ route('admin.enrollments') }}" class="{{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}"><span class="las la-user-check"></span><span>Pendaftaran</span></a></li>
                <li><a href="{{ route('admin.account') }}" class="{{ request()->routeIs('admin.account*') ? 'active' : '' }}"><span class="las la-user-circle"></span><span>Akun</span></a></li>
            @endif


            {{-- ================= MEMBER ================= --}}
            @if($role === 'member')
                <li><a href="{{ route('member.dashboard') }}" class="{{ request()->routeIs('member.dashboard*') ? 'active' : '' }}"><span class="las la-home"></span><span>Dashboard</span></a></li>
                <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile*') ? 'active' : '' }}"><span class="las la-user"></span><span>Profile</span></a></li>
                <li><a href="{{ route('member.enrollments') }}" class="{{ request()->routeIs('member.enrollments*') ? 'active' : '' }}"><span class="las la-book"></span><span>My Enrollments</span></a></li>
                <li><a href="{{ route('member.grades') }}" class="{{ request()->routeIs('member.grades*') ? 'active' : '' }}"><span class="las la-medal"></span><span>My Grades</span></a></li>
                <li><a href="{{ route('member.tasks') }}" class="{{ request()->routeIs('member.tasks*') ? 'active' : '' }}"><span class="las la-clipboard-list"></span><span>My Tasks</span></a></li>
                <li><a href="{{ route('elearning.index') }}" class="{{ request()->routeIs('elearning*') ? 'active' : '' }}"><span class="las la-play-circle"></span><span>E-Learning</span></a></li>
            @endif


            {{-- ================= TUTOR ================= --}}
            @if($role === 'tutor')
                <li><a href="{{ route('tutor.dashboard') }}" class="{{ request()->routeIs('tutor.dashboard') ? 'active' : '' }}"><span class="las la-tachometer-alt"></span><span>Dashboard</span></a></li>
                <li><a href="{{ route('tutor.classes') }}" class="{{ request()->routeIs('tutor.classes*') ? 'active' : '' }}"><span class="las la-chalkboard-teacher"></span><span>Kelas</span></a></li>
                <li><a href="{{ route('tutor.bootcamps') }}" class="{{ request()->routeIs('tutor.bootcamps*') ? 'active' : '' }}"><span class="las la-graduation-cap"></span><span>Bootcamp</span></a></li>
                <li><a href="{{ route('tutor.tasks') }}" class="{{ request()->routeIs('tutor.tasks*') ? 'active' : '' }}"><span class="las la-clipboard-check"></span><span>Tasks & Assignments</span></a></li>
                <li><a href="{{ route('tutor.video-contents.index') }}" class="{{ request()->routeIs('tutor.video-contents*') ? 'active' : '' }}"><span class="las la-video"></span><span>Video Contents</span></a></li>
                <li><a href="{{ route('tutor.account') }}" class="{{ request()->routeIs('tutor.account*') ? 'active' : '' }}"><span class="las la-user-circle"></span><span>Account</span></a></li>
            @endif


            {{-- ================= LOGOUT ================= --}}
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="las la-sign-out-alt"></span>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                    @csrf
                </form>
            </li>

        </ul>
    </div>

</aside>
