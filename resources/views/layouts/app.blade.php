<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'LearnServe')</title>
  
  
  {{-- Bootstrap CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  @include('layouts.header')

  <main class="container py-5">
    @yield('content')
  </main>

  @include('layouts.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Script khusus halaman --}}
  @yield('scripts')
  
</body>
</html>
