<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #1a1c6d, #3f2b96); border-radius: 0 0 20px 20px;">
  <div class="container">
    {{-- Logo --}}
    <a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">
      <img src="https://via.placeholder.com/30x30" alt="Logo" class="me-2" style="border-radius: 50%;">
      LearnServe
    </a>

    {{-- Burger menu (mobile) --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menu --}}
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{ route('home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white fw-semibold" href="#">E-Learning</a></li>
        <li class="nav-item"><a class="nav-link text-white fw-semibold" href="#">Bootcamp</a></li>
      </ul>

      {{-- Buttons --}}
      <div class="d-flex">
        <a href="{{ route('auth') }}" class="btn btn-outline-light me-2 rounded-pill px-4">Sign Up</a>
      </div>
    </div>
  </div>
</nav>
