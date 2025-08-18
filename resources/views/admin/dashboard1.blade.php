<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
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

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 1.5rem; 
            margin-top: 1rem;
        }

        .card-single {
            display: flex;
            justify-content: space-between;
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-single div:last-child span {
            font-size: 2.5rem;
            color: var(--main-color);
        }

        .card-single div:first-child span {
            color: var(--text-grey);
        }

        .card-single:last-child {
            background: var(--main-color);
        }

        .card-single:last-child,
        .card-single:last-child div:first-child span,
        .card-single:last-child div:last-child span {
            color: #fff;
        }

        .recent-grid {
            margin-top: 3.5rem;
            display: grid;
            grid-gap: 2rem;
            grid-template-columns: 1fr 400px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-header,
        .card-body {
            padding: 1rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .card-header button {
            background: var(--main-color);
            border-radius: 10px;
            color: #fff;
            font-size: .8rem;
            padding: .5rem 1rem;
            border: 1px solid var(--main-color);
            cursor: pointer;
        }

        .card-header button:hover {
            background: #5d7ce8;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        thead tr {
            border-top: 1px solid #f0f0f0;
            border-bottom: 2px solid #f0f0f0;
        }

        thead td {
            font-weight: 700;
        }

        td {
            padding: .5rem 1rem;
            vertical-align: middle;
        }

        .class-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        td .status {
            display: inline-block;
            height: 10px;
            width: 10px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        tr td:last-child {
            display: flex;
            align-items: center;
        }

        .status.gray {
            background: #6c757d;
        }

        .status.blue {
            background: #0d6efd;
        }

        .status.green {
            background: #198754;
        }

        .status.teal {
            background: #20c997;
        }

        .status.red {
            background: #dc3545;
        }

        .status.yellow {
            background: #ffc107;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .tutor {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .8rem .2rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .tutor:last-child {
            border-bottom: none;
        }

        .info {
            display: flex;
            align-items: center;
        }

        .info img {
            border-radius: 50%;
            margin-right: 1rem;
            background: #ddd;
        }

        .info h4 {
            font-size: .9rem;
            font-weight: 700;
            color: #222;
            margin-bottom: .2rem;
        }

        .info small {
            font-weight: 600;
            color: var(--text-grey);
        }

        .contact span {
            font-size: 1.2rem;
            display: inline-block;
            margin-left: .3rem;
            color: var(--main-color);
            cursor: pointer;
        }

        .contact span:hover {
            color: #5d7ce8;
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
    </style>
</head>
<body>

    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h1><span class="la la-graduation-cap"></span><span>LearnServe</span></h1>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="" class="active"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href=""><span class="las la-users"></span>
                    <span>Data member</span></a>
                </li>
                <li>
                    <a href=""><span class="las la-clipboard-list"></span>
                    <span>Data Tutor</span></a>
                </li>
                <li>
                    <a href=""><span class="las la-shopping-bag"></span>
                    <span>Data kelas</span></a>
                </li>
                <li>
                    <a href=""><span class="las la-receipt"></span>
                    <span>Pembayaran</span></a>
                </li>
                
                <li>
                    <a href=""><span class="las la-clipboard-list"></span>
                    <span>Tasks</span></a>
                </li>

                <li>
                    <a href=""><span class="las la-user-circle"></span>
                    <span>Account</span></a>
                </li>   
            </ul>
        </div>
    </div>
    
    <div class="main-content">
        <header>
            <h1>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                Dashboard
            </h1>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="search here" />
            </div>

            <div class="user-wrapper">
                <img src="https://via.placeholder.com/40x40/ddd/666?text=N" width="40" height="40" alt="User Avatar">
                <div class="user-info">
                    <h4>Nuraini</h4>
                    <small>Super admin</small>
                </div>
            </div>
        </header>
        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>54</h1>
                        <span>Member</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>79</h1>
                        <span>Tutor</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>124</h1>
                        <span>Kelas</span>
                    </div>
                    <div>
                        <span class="las la-shopping-bag"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>Rp 25M</h1>
                        <span>Transaksi</span>
                    </div>
                    <div>
                        <span class="lab la-google-wallet"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="member">
                    <div class="card">
                        <div class="card-header">
                            <h2>Data Kelas</h2>
                            <button>Lihat semua <span class="las la-arrow-right"></span></button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Foto</td>
                                            <td>Nama Kelas</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><img src="https://via.placeholder.com/60x60/7494ec/fff?text=UI" alt="Kelas" class="class-image"></td>
                                            <td>UI/UX Design Fundamentals</td>
                                            <td>
                                                <span class="status gray"></span>
                                                Draft
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><img src="https://via.placeholder.com/60x60/0d6efd/fff?text=JS" alt="Kelas" class="class-image"></td>
                                            <td>JavaScript Advanced</td>
                                            <td>
                                                <span class="status blue"></span>
                                                Terjadwal
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><img src="https://via.placeholder.com/60x60/198754/fff?text=PY" alt="Kelas" class="class-image"></td>
                                            <td>Python for Beginners</td>
                                            <td>
                                                <span class="status green"></span>
                                                Sedang Berlangsung
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><img src="https://via.placeholder.com/60x60/20c997/fff?text=DB" alt="Kelas" class="class-image"></td>
                                            <td>Database Management</td>
                                            <td>
                                                <span class="status teal"></span>
                                                Selesai
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><img src="https://via.placeholder.com/60x60/dc3545/fff?text=ML" alt="Kelas" class="class-image"></td>
                                            <td>Machine Learning Basics</td>
                                            <td>
                                                <span class="status red"></span>
                                                Dibatalkan 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td><img src="https://via.placeholder.com/60x60/ffc107/fff?text=WD" alt="Kelas" class="class-image"></td>
                                            <td>Web Development Fullstack</td>
                                            <td>
                                                <span class="status yellow"></span>
                                                Diarsipkan
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tutors">
                    <div class="card">
                        <div class="card-header">
                            <h3>Data Tutor</h3>
                            <button>Lihat semua <span class="las la-arrow-right"></span></button>
                        </div>

                        <div class="card-body">
                            <div class="tutor">
                                <div class="info">
                                    <img src="https://via.placeholder.com/40x40/ddd/666?text=BB" width="40" height="40" alt="Tutor Avatar">
                                    <div>
                                        <h4>Bulan Bintang</h4>
                                        <small>UI/UX</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>
                            <div class="tutor">
                                <div class="info">
                                    <img src="https://via.placeholder.com/40x40/ddd/666?text=MS" width="40" height="40" alt="Tutor Avatar">
                                    <div>
                                        <h4>Matahari Senja</h4>
                                        <small>Frontend Dev</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>
                            <div class="tutor">
                                <div class="info">
                                    <img src="https://via.placeholder.com/40x40/ddd/666?text=V" width="40" height="40" alt="Tutor Avatar">
                                    <div>
                                        <h4>Venus</h4>
                                        <small>Backend Dev</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>
                            <div class="tutor">
                                <div class="info">
                                    <img src="https://via.placeholder.com/40x40/ddd/666?text=L" width="40" height="40" alt="Tutor Avatar">
                                    <div>
                                        <h4>Laut Tenang</h4>
                                        <small>Data Science</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>