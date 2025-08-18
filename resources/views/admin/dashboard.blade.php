@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .card-single {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        padding: 2rem 1.5rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        min-height: 120px;
        height: 100%;
    }

    .card-single:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .card-single div:first-child {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-single div:first-child h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        color: #2d3748;
        line-height: 1;
    }

    .card-single div:first-child span {
        color: #718096;
        font-size: 0.95rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .card-single div:last-child {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: rgba(116, 148, 236, 0.1);
    }

    .card-single div:last-child span {
        font-size: 2rem;
        color: #7494ec;
    }

    /* Special styling for the last card (Transaction) */
    .card-single:last-child {
        background: linear-gradient(135deg, #7494ec 0%, #5d7ce8 100%);
        color: #fff;
    }

    .card-single:last-child div:first-child h1,
    .card-single:last-child div:first-child span {
        color: #fff;
    }

    .card-single:last-child div:last-child {
        background: rgba(255, 255, 255, 0.2);
    }

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
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .card-header,
    .card-body {
        padding: 1.5rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f7fafc;
        background: #fafafa;
    }

    .card-header h2,
    .card-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }

    .card-header button {
        background: #7494ec;
        border-radius: 12px;
        color: #fff;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-header button:hover {
        background: #5d7ce8;
        transform: translateY(-1px);
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    thead tr {
        border-bottom: 2px solid #f7fafc;
    }

    thead td {
        font-weight: 600;
        font-size: 0.9rem;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f7fafc;
        font-size: 0.95rem;
        color: #2d3748;
    }

    tbody tr:hover {
        background: #f7fafc;
    }

    .class-image {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    td .status {
        display: inline-block;
        height: 8px;
        width: 8px;
        border-radius: 50%;
        margin-right: 0.75rem;
    }

    tr td:last-child {
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .status.gray { background: #6c757d; }
    .status.blue { background: #0d6efd; }
    .status.green { background: #198754; }
    .status.teal { background: #20c997; }
    .status.red { background: #dc3545; }
    .status.yellow { background: #ffc107; }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .tutor {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f7fafc;
        transition: background 0.3s ease;
    }

    .tutor:hover {
        background: #f7fafc;
        margin: 0 -1.5rem;
        padding: 1rem 1.5rem;
        border-radius: 12px;
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
        background: #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .info small {
        font-weight: 500;
        color: #718096;
        font-size: 0.85rem;
    }

    .contact {
        display: flex;
        gap: 0.5rem;
    }

    .contact span {
        font-size: 1.25rem;
        color: #7494ec;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .contact span:hover {
        color: #5d7ce8;
        background: rgba(116, 148, 236, 0.1);
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card-single">
                <div>
                    <h1>54</h1>
                    <span>Member</span>
                </div>
                <div>
                    <span class="las la-users"></span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card-single">
                <div>
                    <h1>79</h1>
                    <span>Tutor</span>
                </div>
                <div>
                    <span class="las la-users"></span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card-single">
                <div>
                    <h1>124</h1>
                    <span>Kelas</span>
                </div>
                <div>
                    <span class="las la-shopping-bag"></span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
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
                                <td><img src="https://via.placeholder.com/50x50/7494ec/fff?text=UI" alt="Kelas" class="class-image"></td>
                                <td>UI/UX Design Fundamentals</td>
                                <td><span class="status gray"></span>Draft</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><img src="https://via.placeholder.com/50x50/0d6efd/fff?text=JS" alt="Kelas" class="class-image"></td>
                                <td>JavaScript Advanced</td>
                                <td><span class="status blue"></span>Terjadwal</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><img src="https://via.placeholder.com/50x50/198754/fff?text=PY" alt="Kelas" class="class-image"></td>
                                <td>Python for Beginners</td>
                                <td><span class="status green"></span>Sedang Berlangsung</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><img src="https://via.placeholder.com/50x50/20c997/fff?text=DB" alt="Kelas" class="class-image"></td>
                                <td>Database Management</td>
                                <td><span class="status teal"></span>Selesai</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><img src="https://via.placeholder.com/50x50/dc3545/fff?text=ML" alt="Kelas" class="class-image"></td>
                                <td>Machine Learning Basics</td>
                                <td><span class="status red"></span>Dibatalkan</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><img src="https://via.placeholder.com/50x50/ffc107/fff?text=WD" alt="Kelas" class="class-image"></td>
                                <td>Web Development Fullstack</td>
                                <td><span class="status yellow"></span>Diarsipkan</td>
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
@endsection
