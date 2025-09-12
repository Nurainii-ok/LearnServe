@extends('layouts.app')
@section('title', 'Bootcamp & Program')

@section('content')
<div class="container-fluid px-0">

    <style>
    /* ===== Hero Section ===== */
    .hero-section {
        width: 100%;
        min-height: 80vh; /* biar luas */
        background: linear-gradient(135deg, #f8f9fa 0%, #fff4e0 100%);
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0; 
        margin: 0;
    }

    .hero-content {
        max-width: 1200px;   /* biar teks tidak terlalu melebar */
        width: 100%;
        padding: 0 15px;     /* kalau mau mepet kiri kanan hapus baris ini */
    }

    /* ===== Course Card ===== */
    .course-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #fff;
    }

    .course-card img {
        border-radius: 8px;
        max-height: 180px;
        object-fit: cover;
        width: 100%;
    }

    .course-card .card-body {
        text-align: left;
        padding: 1.2rem;
    }

    .course-card h5 {
        font-size: 1rem;
        line-height: 1.4;
        min-height: 45px;
    }

    .course-card p {
        font-size: 0.85rem;
        min-height: 40px;
    }

    /* Hover Effect */
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Rating */
    .course-card .text-warning {
        font-size: 0.85rem;
    }

    /* Harga */
    .course-card .fw-bold.text-brown {
        color: #3d2b1f;
        font-size: 0.95rem;
    }

    /* Harga Diskon */
    .course-price-discount {
        text-decoration: line-through;
        color: #999;
        font-size: 0.8rem;
        margin-left: 5px;
    }
    </style>

    <!-- Hero Section -->
    <section class="hero-section text-dark">
        <div class="hero-content">
            <h1 class="display-4 fw-bold mb-3">
                Kuasai Skill Digital <br>
                dengan <span class="text-warning">Expert</span>
            </h1>
            <p class="lead text-muted mb-4">
                Bergabunglah dengan ribuan profesional yang telah mengembangkan karir mereka melalui bootcamp dan kursus berkualitas tinggi dari para ahli industri.
            </p>

            <div class="row mb-4 text-center">
                <div class="col-4">
                    <h3 class="fw-bold text-warning">50K+</h3>
                    <p class="small text-muted">Alumni</p>
                </div>
                <div class="col-4">
                    <h3 class="fw-bold text-warning">95%</h3>
                    <p class="small text-muted">Job Placement</p>
                </div>
                <div class="col-4">
                    <h3 class="fw-bold text-warning">200+</h3>
                    <p class="small text-muted">Kursus</p>
                </div>
            </div>

            <a href="#courses" class="btn btn-warning btn-lg text-white shadow-sm">
                <i class="fas fa-play"></i> Mulai Belajar
            </a>
        </div>
    </section>

    <!-- Kelas Populer -->
    <section id="courses" class="py-5">
        <div class="container">

            <!--<div class="text-center mb-5">
                <h2 class="fw-bold">Kelas Populer</h2>
                <p class="text-muted">Kelas terpopuler yang banyak diminati dan terbukti mengantarkan siswa meraih kesuksesan</p>
            </div>-->

            <!-- Filter -->
            <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                <button class="btn btn-sm btn-warning text-white active">Semua Kelas</button>
                <button class="btn btn-sm btn-outline-secondary">Programming</button>
                <button class="btn btn-sm btn-outline-secondary">Design</button>
                <button class="btn btn-sm btn-outline-secondary">Business</button>
                <button class="btn btn-sm btn-outline-secondary">Data Science</button>
            </div>

            <!-- Courses Grid -->
            <div class="row g-4">
                <!-- Course Card -->
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 course-card">
                            <img src="{{ asset('assets/Data Analytics.jpg') }}" alt="Excel" class="card-img-top">
                            <div class="card-body">
                                <h6 class="text-warning text-uppercase small fw-bold"></h6>
                                <h5 class="fw-bold mb-2">Data Science & Analytics</h5>
                                <p class="text-muted small mb-3">Belajar Excel mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-warning">⭐ 4.7 (1.5k)</span>
                                    <div>
                                        <span class="fw-bold text-brown">Rp 450.000</span>
                                        <span class="course-price-discount">Rp 2.000.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Course lainnya copy format di atas -->
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 course-card">
                            <img src="{{ asset('assets/Digital marketing.jpg') }}" alt="Excel" class="card-img-top">
                            <div class="card-body">
                                <h6 class="text-warning text-uppercase small fw-bold"></h6>
                                <h5 class="fw-bold mb-2">Digital Marketing</h5>
                                <p class="text-muted small mb-3">Belajar Excel mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-warning">⭐ 4.7 (1.5k)</span>
                                    <div>
                                        <span class="fw-bold text-brown">Rp 450.000</span>
                                        <span class="course-price-discount">Rp 2.000.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 course-card">
                            <img src="{{ asset('assets/Full Stack.jpg') }}" alt="Excel" class="card-img-top">
                            <div class="card-body">
                                <h6 class="text-warning text-uppercase small fw-bold"></h6>
                                <h5 class="fw-bold mb-2">Full Stack Web Development</h5>
                                <p class="text-muted small mb-3">Belajar Excel mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-warning">⭐ 4.7 (1.5k)</span>
                                    <div>
                                        <span class="fw-bold text-brown">Rp 450.000</span>
                                        <span class="course-price-discount">Rp 2.000.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 course-card">
                            <img src="{{ asset('assets/Full Stack.jpg') }}" alt="Excel" class="card-img-top">
                            <div class="card-body">
                                <h6 class="text-warning text-uppercase small fw-bold"></h6>
                                <h5 class="fw-bold mb-2">Full Stack Web Development</h5>
                                <p class="text-muted small mb-3">Belajar Excel mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-warning">⭐ 4.7 (1.5k)</span>
                                    <div>
                                        <span class="fw-bold text-brown">Gratis</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
