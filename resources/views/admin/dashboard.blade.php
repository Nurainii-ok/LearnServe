@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')

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
                <h2>Kelas</h2>
                <a href="{{ route('admin.classes') }}" 
                    class="{{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                    <button>
                        Lihat semua 
                        <span class="las la-arrow-right"></span>
                    </button>
                </a>

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
                <h3>Tutor</h3>
                <a href="{{ route('admin.tutors') }}" 
   class="{{ request()->routeIs('admin.tutors*') ? 'active' : '' }}">
    <button>
        Lihat semua 
        <span class="las la-arrow-right"></span>
    </button>
</a>

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
