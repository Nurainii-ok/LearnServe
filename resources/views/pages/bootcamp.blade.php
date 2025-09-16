@extends('layouts.app')

@section('title', 'Bootcamp & Program')

{{-- CSS --}}
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bootcamp.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <h1>Bootcamp yang Memberi Hasil. Fokus Praktik & Portfolio.</h1>
                    <p>Full Online dan Dipandu oleh Praktisi Senior. Fokus bantu kembangkan skill dan portfolio ribuan alumni.</p>
                    <a href="#programs" class="btn btn-warning me-2"><i class="fas fa-target"></i> Lihat Program</a>
                    <a href="#promo" class="btn btn-dark"><i class="fas fa-gift"></i> Dapatkan Promo</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/Bootcamp.jpg') }}" alt="Bootcamp" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section text-center">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3"><h3>5000+</h3><p>Alumni Tersertifikasi</p></div>
                <div class="col-6 col-md-3"><h3>95%</h3><p>Tingkat Kepuasan</p></div>
                <div class="col-6 col-md-3"><h3>50+</h3><p>Program Tersedia</p></div>
                <div class="col-6 col-md-3"><h3>24/7</h3><p>Dukungan Mentor</p></div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="py-5" id="programs">
        <div class="container">
            <div class="text-center mb-5">
                <h2><i class="fas fa-rocket"></i> Program Bootcamp & Kelas</h2>
                <p>Pilih program yang sesuai dengan kebutuhan karir Anda.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <a href="{{ route('deskripsi_kelas') }}" class="text-decoration-none text-dark">
                        <div class="card course-card h-100 shadow-sm">
                            <!-- Gambar -->
                            <img src="{{ asset('assets/Bootcamp.jpg') }}" 
                                class="card-img-top" alt="Digital Marketing">

                            <!-- Body -->
                            <div class="card-body">
                                <h6 class="card-title text-uppercase fw-bold">
                                    Microsoft Excel Basic to Advanced: Fullstack
                                </h6>

                                <!-- Tanggal -->
                                <div class="mb-2 text-muted small">
                                    <i class="fas fa-calendar"></i> Mulai: 30 Oktober 2025
                                </div>

                                <!-- Harga -->
                                <div class="fw-bold">
                                    <span class="text-primary fs-5">Rp 450.000</span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp 2.000.000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-md-4">
                    <a href="{{ route('deskripsi_kelas') }}" class="text-decoration-none text-dark">
                        <div class="card course-card h-100 shadow-sm">
                            <!-- Gambar -->
                            <img src="{{ asset('assets/Bootcamp.jpg') }}" 
                                class="card-img-top" alt="Digital Marketing">

                            <!-- Body -->
                            <div class="card-body">
                                <h6 class="card-title text-uppercase fw-bold">
                                    Microsoft Excel Basic to Advanced: Fullstack
                                </h6>

                                <!-- Tanggal -->
                                <div class="mb-2 text-muted small">
                                    <i class="fas fa-calendar"></i> Mulai: 30 Oktober 2025
                                </div>

                                <!-- Harga -->
                                <div class="fw-bold">
                                    <span class="text-primary fs-5">Rp 450.000</span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp 2.000.000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-md-4">
                    <a href="{{ route('deskripsi_kelas') }}" class="text-decoration-none text-dark">
                        <div class="card course-card h-100 shadow-sm">
                            <!-- Gambar -->
                            <img src="{{ asset('assets/Bootcamp.jpg') }}" 
                                class="card-img-top" alt="Digital Marketing">

                            <!-- Body -->
                            <div class="card-body">
                                <h6 class="card-title text-uppercase fw-bold">
                                    Microsoft Excel Basic to Advanced: Fullstack
                                </h6>

                                <!-- Tanggal -->
                                <div class="mb-2 text-muted small">
                                    <i class="fas fa-calendar"></i> Mulai: 30 Oktober 2025
                                </div>

                                <!-- Harga -->
                                <div class="fw-bold">
                                    <span class="text-primary fs-5">Rp 450.000</span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp 2.000.000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Corporate Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2><i class="fas fa-building"></i> E-learning & Training Untuk Perusahaan</h2>
            <p>Miliki akses ratusan konten e-learning LearnServe serta dukungan corporate training untuk perusahaan.</p>
            <div class="row g-3 my-4">
                <div class="col-6 col-md-2"><div class="partner-logo">Microsoft</div></div>
                <div class="col-6 col-md-2"><div class="partner-logo">Mandiri</div></div>
                <div class="col-6 col-md-2"><div class="partner-logo">BI</div></div>
                <div class="col-6 col-md-2"><div class="partner-logo">Mizan</div></div>
                <div class="col-6 col-md-2"><div class="partner-logo">Tokopedia</div></div>
                <div class="col-6 col-md-2"><div class="partner-logo">Gojek</div></div>
            </div>
            <a href="#" class="btn btn-warning"><i class="fas fa-phone"></i> Hubungi Tim LearnServe</a>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
