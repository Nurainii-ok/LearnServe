@extends('layouts.app')
@section('title', 'E-Learning')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/learning.css') }}">
@endsection

@section('content')

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

    <!-- Filter Kategori -->
    <div class="category-filter">
        <div class="container">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <a href="#all-courses" class="btn btn-sm btn-warning text-white">Semua Kelas</a>
                <a href="#web-development" class="btn btn-sm btn-outline-secondary">Pengembangan Web</a>
                <a href="#data-science" class="btn btn-sm btn-outline-secondary">Data Science</a>
                <a href="#digital-marketing" class="btn btn-sm btn-outline-secondary">Digital Marketing</a>
                <a href="#excel" class="btn btn-sm btn-outline-secondary">Excel</a>
            </div>
        </div>
    </div>

    <!-- Kelas Populer -->
    <section id="courses" class="py-5">
        <div class="container">
            <!-- Section Semua Kelas -->
            <div id="all-courses" class="category-section">
                <h2 class="fw-bold mb-4">Semua Kelas</h2>
                <div class="row g-4">
                    <!-- Course Card - Data Science -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Data Analytics.jpg') }}" alt="Data Science" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Data Science</h6>
                                    <h5 class="fw-bold mb-2">Data Science & Analytics</h5>
                                    <p class="text-muted small mb-3">Belajar analisis data mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Rp 450.000</span>
                                            <span class="course-price-discount">Rp 2.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Course Card - Digital Marketing -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Digital marketing.jpg') }}" alt="Digital Marketing" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Digital Marketing</h6>
                                    <h5 class="fw-bold mb-2">Digital Marketing</h5>
                                    <p class="text-muted small mb-3">Kuasi strategi pemasaran digital untuk meningkatkan bisnis.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Rp 450.000</span>
                                            <span class="course-price-discount">Rp 2.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Course Card - Excel -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Excel.jpeg') }}" alt="Excel" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Excel</h6>
                                    <h5 class="fw-bold mb-2">Excel</h5>
                                    <p class="text-muted small mb-3">Belajar Excel mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Gratis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Course Card - Web Development -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Full Stack.jpg') }}" alt="Web Development" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Web Development</h6>
                                    <h5 class="fw-bold mb-2">Full Stack Web Development</h5>
                                    <p class="text-muted small mb-3">Jadi developer web full stack dengan belajar frontend dan backend.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Rp 450.000</span>
                                            <span class="course-price-discount">Rp 2.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Section Pengembangan Web -->
            <div id="web-development" class="category-section mt-5">
                <h2 class="fw-bold mb-4">Pengembangan Web</h2>
                <div class="row g-4">
                    <!-- Course Card - Web Development -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Full Stack.jpg') }}" alt="Web Development" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Web Development</h6>
                                    <h5 class="fw-bold mb-2">Full Stack Web Development</h5>
                                    <p class="text-muted small mb-3">Jadi developer web full stack dengan belajar frontend dan backend.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Rp 450.000</span>
                                            <span class="course-price-discount">Rp 2.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Tambahkan lebih banyak kursus web development di sini -->
                </div>
            </div>

            <!-- Section Data Science -->
            <div id="data-science" class="category-section mt-5">
                <h2 class="fw-bold mb-4">Data Science</h2>
                <div class="row g-4">
                    <!-- Course Card - Data Science -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Data Analytics.jpg') }}" alt="Data Science" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Data Science</h6>
                                    <h5 class="fw-bold mb-2">Data Science & Analytics</h5>
                                    <p class="text-muted small mb-3">Belajar analisis data mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Rp 450.000</span>
                                            <span class="course-price-discount">Rp 2.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Tambahkan lebih banyak kursus data science di sini -->
                </div>
            </div>

            <!-- Section Digital Marketing -->
            <div id="digital-marketing" class="category-section mt-5">
                <h2 class="fw-bold mb-4">Digital Marketing</h2>
                <div class="row g-4">
                    <!-- Course Card - Digital Marketing -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Digital marketing.jpg') }}" alt="Digital Marketing" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Digital Marketing</h6>
                                    <h5 class="fw-bold mb-2">Digital Marketing</h5>
                                    <p class="text-muted small mb-3">Kuasi strategi pemasaran digital untuk meningkatkan bisnis.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Rp 450.000</span>
                                            <span class="course-price-discount">Rp 2.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Tambahkan lebih banyak kursus digital marketing di sini -->
                </div>
            </div>

            <!-- Section Excel -->
            <div id="excel" class="category-section mt-5">
                <h2 class="fw-bold mb-4">Excel</h2>
                <div class="row g-4">
                    <!-- Course Card - Excel -->
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => 3]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ asset('assets/Excel.jpeg') }}" alt="Excel" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="text-warning text-uppercase small fw-bold">Excel</h6>
                                    <h5 class="fw-bold mb-2">Excel</h5>
                                    <p class="text-muted small mb-3">Belajar Excel mulai dari dasar hingga advanced dengan praktik langsung.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning">⭐ 4.7 <!--(1.5k)--></span>
                                        <div>
                                            <span class="fw-bold text-brown">Gratis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Tambahkan lebih banyak kursus Excel di sini -->
                </div>
            </div>
        </div>
    </section>
</div>

@section('scripts')
<script>
    // Script untuk menangani filter kategori
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.category-filter a');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Hapus kelas active dari semua tombol
                filterButtons.forEach(btn => btn.classList.remove('btn-warning', 'text-white'));
                filterButtons.forEach(btn => btn.classList.add('btn-outline-secondary'));
                
                // Tambahkan kelas active ke tombol yang diklik
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-warning', 'text-white');
            });
        });
        
        // Menangani perubahan URL hash (ketika user mengklik link dengan hash)
        window.addEventListener('hashchange', function() {
            const hash = window.location.hash;
            if (hash) {
                // Hapus kelas active dari semua tombol
                filterButtons.forEach(btn => btn.classList.remove('btn-warning', 'text-white'));
                filterButtons.forEach(btn => btn.classList.add('btn-outline-secondary'));
                
                // Tambahkan kelas active ke tombol yang sesuai
                const activeButton = document.querySelector(`.category-filter a[href="${hash}"]`);
                if (activeButton) {
                    activeButton.classList.remove('btn-outline-secondary');
                    activeButton.classList.add('btn-warning', 'text-white');
                }
            }
        });
    });
</script>
@endsection
@endsection