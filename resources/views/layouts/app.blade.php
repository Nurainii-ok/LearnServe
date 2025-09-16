<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'LearnServe')</title>
  
  
  {{-- Bootstrap CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/header_footer.css') }}">
  
  {{-- Global CSS --}}
  <style>
    body { background-color: #f5f7fa; }
    .hero { background-color: #eef2ff; border-radius: 8px; padding: 60px 20px; }
    .card-custom { border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05); }
  </style>

  {{-- CSS khusus halaman --}}
  @yield('styles')
</head>
<body>
  @include('partials.header')

  <main {{--class="container py-5"--}}>
    @yield('content')
  </main>

  @include('partials.footer')

  <!-- Bootstrap JS (REQUIRED for dropdown & navbar toggle) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Simple and reliable dropdown initialization -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Simple initialization without complex configuration
      const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
      const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
      });
      
      console.log('Dropdowns initialized:', dropdownList.length);
    });
  </script>

  {{-- Script khusus halaman --}}
  @yield('scripts')
  
</body>
</html>
