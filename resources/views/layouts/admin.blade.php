<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - LearnServe Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')

</head>
<body>
    <input type="checkbox" id="nav-toggle">
    
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        @include('admin.partials.header')
        
        <main>
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>