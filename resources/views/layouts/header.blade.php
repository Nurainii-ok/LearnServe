<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/header_footer.css') }}">
</head>
<body>
  <nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="#">
      <img src="https://img.icons8.com/ios-filled/30/ffffff/graduation-cap.png" alt="Logo" class="me-2"/>
      LearnServe
    </a>

    <!-- Toggle button (mobile) -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="{{ route('learning') }}">E-Learning</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="{{ route('bootcamp') }}">Bootcamp</a>
        </li>
      </ul>

      <!-- Tombol Login & Register -->
      <div class="d-flex">
        <a href="{{ route('auth') }}" class="btn btn-outline-light me-2 custom-login-btn">Login</a>
        <a href="{{ route('auth') }}" class="btn btn-warning fw-semibold custom-register-btn">Register</a>
      </div>
    </div>
  </div>
</nav>



</body>
</html>
