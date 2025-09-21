<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('home') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/Logo.jpg') }}" alt="LearnServe" style="height: 32px; width: auto;">
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2" style="color: var(--primary-brown);">LearnServe</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    <!-- Dashboard -->
    <li class="menu-item {{ request()->routeIs('member.dashboard*') ? 'active' : '' }}">
      <a href="{{ route('member.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>

    <!-- Profile -->
    <li class="menu-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
      <a href="{{ route('profile') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Profile">Profile</div>
      </a>
    </li>

    <!-- Divider -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Learning</span>
    </li>

    <!-- My Enrollments -->
    <li class="menu-item {{ request()->routeIs('member.enrollments*') ? 'active' : '' }}">
      <a href="{{ route('member.enrollments') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
        <div data-i18n="Enrollments">My Enrollments</div>
      </a>
    </li>

    <!-- My Grades -->
    <li class="menu-item {{ request()->routeIs('member.grades*') ? 'active' : '' }}">
      <a href="{{ route('member.grades') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-trophy"></i>
        <div data-i18n="Grades">My Grades</div>
      </a>
    </li>

    <!-- My Tasks -->
    <li class="menu-item {{ request()->routeIs('member.tasks*') ? 'active' : '' }}">
      <a href="{{ route('member.tasks') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-task"></i>
        <div data-i18n="Tasks">My Tasks</div>
      </a>
    </li>

    <!-- E-Learning -->
    <li class="menu-item {{ request()->routeIs('elearning*') ? 'active' : '' }}">
      <a href="{{ route('elearning.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-play-circle"></i>
        <div data-i18n="E-Learning">E-Learning</div>
      </a>
    </li>

    <!-- Divider -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Explore</span>
    </li>

    <!-- Home/Learning -->
    <li class="menu-item">
      <a href="{{ route('home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home"></i>
        <div data-i18n="Home">Home</div>
      </a>
    </li>

    <!-- E-Learning -->
    <li class="menu-item">
      <a href="{{ route('learning') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div data-i18n="Learning">E-Learning</div>
      </a>
    </li>

    <!-- Bootcamp -->
    <li class="menu-item">
      <a href="{{ route('bootcamp') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-code-alt"></i>
        <div data-i18n="Bootcamp">Bootcamp</div>
      </a>
    </li>

    <!-- Divider -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Account</span>
    </li>

    <!-- Logout -->
    <li class="menu-item">
      <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="menu-link border-0 bg-transparent w-100 text-start" style="color: inherit;">
          <i class="menu-icon tf-icons bx bx-power-off"></i>
          <div data-i18n="Logout">Logout</div>
        </button>
      </form>
    </li>

  </ul>
</aside>