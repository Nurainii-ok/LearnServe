<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - LearnServe Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        :root {
            --main-color: #7494ec;
            --color-dark: #1D2231;
            --text-grey: #8390A2;
        }

        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            list-style-type: none;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar{
            width: 300px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background: var(--main-color);
            z-index: 100;
            transition: width 300ms;
        }
        
        .sidebar-brand {
            height: 90px;
            padding: 1rem 0rem 1rem 2rem;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .sidebar-brand span {
            display: inline-block;
            padding-right: 1rem;
        }

        .sidebar-menu {
            margin-top: 1rem;
        }

        .sidebar-menu li {
            width: 100%;
            margin-bottom: 1.7rem;
            padding-left: 2rem;
        }

        .sidebar-menu a {
            padding-left: 1rem;
            display: block;
            color: #fff;
            font-size: 1.1rem;
        }

        .sidebar-menu a.active {
            background: #f1f5f9;
            padding-top: 1rem;
            padding-bottom: 1rem;
            color: var(--main-color);
            border-radius: 30px 0px 0px 30px;
        }

        .sidebar-menu a span:first-child {
            font-size: 1.5rem;
            padding-right: 1rem;
        }
 
        #nav-toggle:checked + .sidebar {
            width: 70px;
        }

        #nav-toggle:checked + .sidebar .sidebar-brand,
        #nav-toggle:checked + .sidebar li {
            padding-left: 1rem;
        }

        #nav-toggle:checked + .sidebar li a{
            padding-left: 0rem;
        }

        #nav-toggle:checked + .sidebar .sidebar-brand h1 span:last-child,
        #nav-toggle:checked + .sidebar li a span:last-child {
            display: none;
        }

        #nav-toggle:checked ~ .main-content {
            margin-left: 70px;
        }

        #nav-toggle:checked ~ .main-content header {
            width: calc(100% - 70px);
            left: 70px;
        }

        .main-content {
            transition: margin-left 300ms;
            margin-left: 300px;
        }

        header {
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            position: fixed;
            left: 300px;
            width: calc(100% - 300px);
            top: 0;
            z-index: 100;
            transition: left 300ms, width 300ms;
        }

        #nav-toggle {
            display: none;
        }

        header h1 {
            color: #222;
            display: flex;
            align-items: center;
        }

        header label span {
            font-size: 1.7rem;
            padding-right: 1rem;
        }

        .search-wrapper {
            border: 1px solid #ccc;
            border-radius: 30px;
            height: 50px;
            display: flex;
            align-items: center;
            overflow: hidden;
            flex: 1;
            max-width: 300px;
            margin: 0 2rem;
        }

        .search-wrapper span {
            display: inline-block;
            padding: 0rem 1rem;
            font-size: 1.5rem;
        }

        .search-wrapper input {
            height: 100%;
            padding: .5rem;
            border: none;
            outline: none;
            flex: 1;
        }

        .user-wrapper {
            display: flex;
            align-items: center;
        }

        .user-wrapper img {
            border-radius: 50%;
            margin-right: 1rem;
            background: #ddd;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-info h4 {
            font-size: .9rem;
            color: #222;
        }

        .user-info small {
            color: var(--text-grey);
        }

        main {
            margin-top: 90px;
            padding: 2rem 1.5rem;
            background: #f1f5f9;
            min-height: calc(100vh - 90px);
        }

        /* Media Queries for Better Responsiveness */
        @media only screen and (max-width: 1200px) {
            .recent-grid {
                grid-template-columns: 1fr 350px;
            }
        }

        @media only screen and (max-width: 1024px) {
            .sidebar {
                width: 70px;
            }

            .sidebar .sidebar-brand,
            .sidebar li {
                padding-left: 1rem;
                text-align: center;
            }

            .sidebar li a{
               padding-left: 0rem;
            }

            .sidebar .sidebar-brand h1 span:last-child,
            .sidebar li a span:last-child {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .main-content header {
                width: calc(100% - 70px);
                left: 70px;
            }

            .recent-grid {
                grid-template-columns: 1fr;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media only screen and (max-width: 768px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
                grid-gap: 1rem;
            }

            .search-wrapper {
                display: none;
            }

            .sidebar {
                left: -100%;
            }

            header h1 label {
                background: var(--main-color);
                padding: .5rem;
                margin-right: 1rem;
                height: 40px;
                width: 40px;
                border-radius: 50%;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            header h1 label span {
                padding-right: 0;
            }

            header h1 {
                font-size: 1.1rem;
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            header {
                width: 100% !important;
                left: 0 !important;
            }

            #nav-toggle:checked + .sidebar {
                left: 0 !important;
                z-index: 200;
                width: 300px;            
            }

            #nav-toggle:checked + .sidebar .sidebar-brand,
            #nav-toggle:checked + .sidebar li {
                padding-left: 2rem;
                text-align: left;
            }

            #nav-toggle:checked + .sidebar li a{
               padding-left: 1rem;
            }

            #nav-toggle:checked + .sidebar .sidebar-brand h1 span:last-child,
            #nav-toggle:checked + .sidebar li a span:last-child {
                display: inline;
            }

            #nav-toggle:checked ~ .main-content {
                margin-left: 0 !important;
            }

            .user-wrapper {
                flex-direction: column;
                align-items: flex-end;
            }

            .user-info {
                text-align: right;
            }
        }

        @media only screen and (max-width: 600px) {
            .cards {
                grid-template-columns: 1fr;
            }

            main {
                padding: 1rem;
            }

            .card-single {
                padding: 1.5rem;
            }

            .tutor {
                flex-direction: column;
                align-items: flex-start;
                gap: .5rem;
            }

            .contact {
                align-self: flex-end;
            }
        }

        @media only screen and (max-width: 480px) {
            header {
                padding: 1rem;
            }

            header h1 {
                font-size: 1rem;
            }

            .user-info h4 {
                font-size: .8rem;
            }

            .user-info small {
                font-size: .7rem;
            }

            .card-header h2,
            .card-header h3 {
                font-size: 1rem;
            }

            .card-header button {
                font-size: .7rem;
                padding: .4rem .8rem;
            }

            table {
                font-size: .8rem;
            }

            .class-image {
                width: 50px;
                height: 50px;
            }
        }

        @yield('styles')
    </style>
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