<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LearnServe Tutor</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Line Awesome Icons -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Tutor CSS -->
    <link rel="stylesheet" href="{{ asset('css/tutor.css') }}">
    
    @yield('styles')
</head>

<body>
    <!-- Toggle buat mobile -->
    <input type="checkbox" id="nav-toggle" hidden>
    
    {{-- Sidebar --}}
    @include('partials.tutor.sidebar')
    
    {{-- Main Content --}}
    <div class="main-content">
        
        {{-- Header --}}
        @include('partials.tutor.header')

        {{-- Page Wrapper (isi setelah header) --}}
        <main class="page-wrapper">
            @yield('content')
        </main>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        const navToggle = document.getElementById('nav-toggle');
        navToggle.addEventListener('change', () => {
            document.body.classList.toggle('sidebar-open', navToggle.checked);
        });
    </script>

    @yield('scripts')
</body>
</html>
