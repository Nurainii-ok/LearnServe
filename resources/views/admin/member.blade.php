<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Member - LearnServe</title>
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h2 {
            color: var(--color-dark);
            font-size: 1.8rem;
            font-weight: 600;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-select {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
            color: var(--color-dark);
            cursor: pointer;
        }

        .export-btn {
            background: var(--main-color);
            color: white;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.3s;
        }

        .export-btn:hover {
            background: #5d7ce8;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
        }

        .stat-info p {
            color: var(--text-grey);
            font-size: 0.9rem;
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--main-color);
        }

        .members-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            color: var(--color-dark);
            font-size: 1.3rem;
            font-weight: 600;
        }

        .table-search {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid #e9ecef;
        }

        .table-search input {
            border: none;
            background: transparent;
            outline: none;
            margin-left: 0.5rem;
            font-size: 0.9rem;
            width: 200px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--color-dark);
            font-size: 0.9rem;
            border-bottom: 2px solid #e9ecef;
        }

        tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .member-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .member-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--main-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .member-info h4 {
            font-size: 0.95rem;
            color: var(--color-dark);
            margin-bottom: 0.2rem;
            font-weight: 500;
        }

        .member-info p {
            font-size: 0.8rem;
            color: var(--text-grey);
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-align: center;
        }

        .status-active {
            background: #d1edff;
            color: #0066cc;
        }

        .status-inactive {
            background: #ffe6e6;
            color: #cc0000;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .subscription-badge {
            padding: 0.3rem 0.7rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .sub-premium {
            background: #ffd700;
            color: #b8860b;
        }

        .sub-basic {
            background: #e9ecef;
            color: #495057;
        }

        .sub-pro {
            background: #d4edda;
            color: #155724;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.4rem 0.6rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s;
        }

        .btn-view {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-view:hover {
            background: #bbdefb;
        }

        .btn-edit {
            background: #fff3e0;
            color: #f57c00;
        }

        .btn-edit:hover {
            background: #ffe0b2;
        }

        .btn-delete {
            background: #ffebee;
            color: #d32f2f;
        }

        .btn-delete:hover {
            background: #ffcdd2;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            gap: 0.5rem;
        }

        .pagination button {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background: white;
            color: var(--color-dark);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pagination button:hover:not(.active) {
            background: #f8f9fa;
        }

        .pagination button.active {
            background: var(--main-color);
            color: white;
            border-color: var(--main-color);
        }

        .pagination .page-info {
            margin: 0 1rem;
            color: var(--text-grey);
            font-size: 0.9rem;
        }

        /* Media Queries */
        @media only screen and (max-width: 1200px) {
            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
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

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media only screen and (max-width: 768px) {
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

            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .filter-controls {
                width: 100%;
                justify-content: flex-end;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .table-search input {
                width: 150px;
            }
        }

        @media only screen and (max-width: 600px) {
            main {
                padding: 1rem;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .stats-cards {
                gap: 1rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .table-container {
                font-size: 0.8rem;
            }

            .member-avatar {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
            }

            .action-buttons {
                flex-direction: column;
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
                    <a href="dashboard.html"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="#" class="active"><span class="las la-users"></span>
                    <span>Data member</span></a>
                </li>
                <li>
                    <a href="data-tutor.html"><span class="las la-clipboard-list"></span>
                    <span>Data Tutor</span></a>
                </li>
                <li>
                    <a href="data-kelas.html"><span class="las la-shopping-bag"></span>
                    <span>Data kelas</span></a>
                </li>
                <li>
                    <a href="pembayaran.html"><span class="las la-receipt"></span>
                    <span>Pembayaran</span></a>
                </li>
                
                <li>
                    <a href="tasks.html"><span class="las la-clipboard-list"></span>
                    <span>Tasks</span></a>
                </li>

                <li>
                    <a href="account.html"><span class="las la-user-circle"></span>
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
                Data Member
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
            <div class="page-header">
                <h2>Data Member</h2>
                <div class="filter-controls">
                    <select class="filter-select">
                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Tidak Aktif</option>
                        <option>Pending</option>
                    </select>
                    <select class="filter-select">
                        <option>Semua Langganan</option>
                        <option>Basic</option>
                        <option>Premium</option>
                        <option>Pro</option>
                    </select>
                    <button class="export-btn">
                        <span class="las la-download"></span>
                        Export
                    </button>
                </div>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>54</h3>
                        <p>Total Member</p>
                    </div>
                    <div class="stat-icon">
                        <span class="las la-users"></span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>48</h3>
                        <p>Member Aktif</p>
                    </div>
                    <div class="stat-icon">
                        <span class="las la-user-check"></span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>6</h3>
                        <p>Member Tidak Aktif</p>
                    </div>
                    <div class="stat-icon">
                        <span class="las la-user-times"></span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>12</h3>
                        <p>Member Baru Bulan Ini</p>
                    </div>
                    <div class="stat-icon">
                        <span class="las la-user-plus"></span>
                    </div>
                </div>
            </div>

            <div class="members-table">
                <div class="table-header">
                    <h3>Daftar Member</h3>
                    <div class="table-search">
                        <span class="las la-search"></span>
                        <input type="text" placeholder="Cari member...">
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Langganan</th>
                                <th>Kelas Diikuti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#001</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">AS</div>
                                        <div class="member-info">
                                            <h4>Andi Saputra</h4>
                                            <p>+62 812-3456-7890</p>
                                        </div>
                                    </div>
                                </td>
                                <td>andi.saputra@email.com</td>
                                <td>15 Jan 2025</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-premium">Premium</span>
                                </td>
                                <td>3 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#006</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">LR</div>
                                        <div class="member-info">
                                            <h4>Linda Rahmawati</h4>
                                            <p>+62 888-2222-3333</p>
                                        </div>
                                    </div>
                                </td>
                                <td>linda.rahmawati@email.com</td>
                                <td>03 Jan 2025</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-pro">Pro</span>
                                </td>
                                <td>4 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#007</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">BW</div>
                                        <div class="member-info">
                                            <h4>Budi Wijaya</h4>
                                            <p>+62 899-4444-5555</p>
                                        </div>
                                    </div>
                                </td>
                                <td>budi.wijaya@email.com</td>
                                <td>28 Des 2024</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-basic">Basic</span>
                                </td>
                                <td>1 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#008</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">MC</div>
                                        <div class="member-info">
                                            <h4>Maya Cahyani</h4>
                                            <p>+62 811-6666-7777</p>
                                        </div>
                                    </div>
                                </td>
                                <td>maya.cahyani@email.com</td>
                                <td>25 Des 2024</td>
                                <td>
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-premium">Premium</span>
                                </td>
                                <td>0 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#009</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">AG</div>
                                        <div class="member-info">
                                            <h4>Ahmad Gunawan</h4>
                                            <p>+62 822-8888-9999</p>
                                        </div>
                                    </div>
                                </td>
                                <td>ahmad.gunawan@email.com</td>
                                <td>20 Des 2024</td>
                                <td>
                                    <span class="status-badge status-inactive">Tidak Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-basic">Basic</span>
                                </td>
                                <td>1 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#010</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">NN</div>
                                        <div class="member-info">
                                            <h4>Nita Nurmalasari</h4>
                                            <p>+62 833-1111-2222</p>
                                        </div>
                                    </div>
                                </td>
                                <td>nita.nurmalasari@email.com</td>
                                <td>18 Des 2024</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-pro">Pro</span>
                                </td>
                                <td>6 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <button>
                        <span class="las la-angle-left"></span>
                        Sebelumnya
                    </button>
                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button>4</button>
                    <button>5</button>
                    <div class="page-info">
                        Menampilkan 1-10 dari 54 member
                    </div>
                    <button>
                        Selanjutnya
                        <span class="las la-angle-right"></span>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Search functionality
        document.querySelector('.table-search input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const memberName = row.querySelector('.member-info h4').textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                
                if (memberName.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter functionality
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                // Filter logic would be implemented here
                // For now, this is just a placeholder
                console.log('Filter changed:', this.value);
            });
        });

        // Action button functionality
        document.querySelectorAll('.btn-action').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const action = this.classList.contains('btn-view') ? 'view' : 
                             this.classList.contains('btn-edit') ? 'edit' : 'delete';
                const row = this.closest('tr');
                const memberId = row.cells[0].textContent;
                const memberName = row.querySelector('.member-info h4').textContent;
                
                if (action === 'delete') {
                    if (confirm(`Apakah Anda yakin ingin menghapus member ${memberName}?`)) {
                        // Delete logic would be implemented here
                        console.log('Delete member:', memberId);
                    }
                } else {
                    // View or edit logic would be implemented here
                    console.log(`${action} member:`, memberId);
                }
            });
        });

        // Export functionality
        document.querySelector('.export-btn').addEventListener('click', function() {
            // Export logic would be implemented here
            alert('Fitur export akan segera tersedia!');
        });

        // Pagination functionality
        document.querySelectorAll('.pagination button').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('active')) return;
                
                // Remove active class from all buttons
                document.querySelectorAll('.pagination button').forEach(b => {
                    b.classList.remove('active');
                });
                
                // Add active class to clicked button (if it's a number)
                if (!isNaN(this.textContent)) {
                    this.classList.add('active');
                }
                
                // Pagination logic would be implemented here
                console.log('Page changed to:', this.textContent);
            });
        });

        // Responsive table handling
        function handleResponsiveTable() {
            const table = document.querySelector('table');
            const container = document.querySelector('.table-container');
            
            if (window.innerWidth < 768) {
                table.style.minWidth = '700px';
            } else {
                table.style.minWidth = 'auto';
            }
        }

        window.addEventListener('resize', handleResponsiveTable);
        handleResponsiveTable();
    </script>

</body>
</html></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">SP</div>
                                        <div class="member-info">
                                            <h4>Sari Pratiwi</h4>
                                            <p>+62 821-9876-5432</p>
                                        </div>
                                    </div>
                                </td>
                                <td>sari.pratiwi@email.com</td>
                                <td>12 Jan 2025</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-basic">Basic</span>
                                </td>
                                <td>1 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#003</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">RM</div>
                                        <div class="member-info">
                                            <h4>Rizki Maulana</h4>
                                            <p>+62 813-5555-4444</p>
                                        </div>
                                    </div>
                                </td>
                                <td>rizki.maulana@email.com</td>
                                <td>10 Jan 2025</td>
                                <td>
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-pro">Pro</span>
                                </td>
                                <td>0 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#004</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">DN</div>
                                        <div class="member-info">
                                            <h4>Dina Novita</h4>
                                            <p>+62 856-7777-8888</p>
                                        </div>
                                    </div>
                                </td>
                                <td>dina.novita@email.com</td>
                                <td>08 Jan 2025</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-premium">Premium</span>
                                </td>
                                <td>5 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye"></span>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <span class="las la-edit"></span>
                                        </button>
                                        <button class="btn-action btn-delete" title="Hapus">
                                            <span class="las la-trash"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#005</td>
                                <td>
                                    <div class="member-profile">
                                        <div class="member-avatar">FA</div>
                                        <div class="member-info">
                                            <h4>Fajar Ananda</h4>
                                            <p>+62 877-9999-1111</p>
                                        </div>
                                    </div>
                                </td>
                                <td>fajar.ananda@email.com</td>
                                <td>05 Jan 2025</td>
                                <td>
                                    <span class="status-badge status-inactive">Tidak Aktif</span>
                                </td>
                                <td>
                                    <span class="subscription-badge sub-basic">Basic</span>
                                </td>
                                <td>2 Kelas</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <span class="las la-eye">