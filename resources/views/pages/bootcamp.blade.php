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
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Bootcamp yang Memberi Hasil. Fokus Praktik & Portfolio.</h1>
                    <p>Full Online dan Dipandu oleh Praktisi Senior. Fokus bantu kembangkan skill dan portfolio ribuan alumni.</p>
                    <div class="hero-buttons">
                        <a href="#programs" class="btn btn-warning"><i class="fas fa-target me-2"></i> Lihat Program</a>
                        <!--<a href="#promo" class="btn btn-dark"><i class="fas fa-gift me-2"></i> Dapatkan Promo</a>-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/Bootcamp.jpg') }}" alt="Bootcamp" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 mb-4 mb-md-0">
                    <h3>5000+</h3>
                    <p>Alumni Tersertifikasi</p>
                </div>
                <div class="col-6 col-md-3 mb-4 mb-md-0">
                    <h3>95%</h3>
                    <p>Tingkat Kepuasan</p>
                </div>
                <div class="col-6 col-md-3">
                    <h3>50+</h3>
                    <p>Program Tersedia</p>
                </div>
                <div class="col-6 col-md-3">
                    <h3>24/7</h3>
                    <p>Dukungan Mentor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="program-section" id="programs">
        <div class="container">
            <div class="text-center mb-5">
                <h2><i class="fas fa-rocket me-2"></i> Program Bootcamp & Kelas</h2>
                <p>Pilih program yang sesuai dengan kebutuhan karir Anda.</p>
            </div>

            <div class="row g-4">
                <!-- Program 1 -->
                <div class="col-md-4">
                    <a href="{{ route('deskripsi_bootcamp') }}" class="text-decoration-none">
                        <div class="card course-card h-100">
                            <img src="{{ asset('assets/Bootcamp.jpg') }}" class="card-img-top" alt="Digital Marketing">
                            <div class="card-body">
                                <h6 class="card-title">Microsoft Excel Basic to Advanced: Fullstack</h6>
                                <div class="mb-2 text-muted small">
                                    <i class="fas fa-calendar me-1"></i> Mulai: 30 Oktober 2025
                                </div>
                                <div class="fw-bold">
                                    <span class="text-primary">Rp 450.000</span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp 2.000.000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Program 2 -->
                <div class="col-md-4">
                    <a href="{{ route('deskripsi_bootcamp') }}" class="text-decoration-none">
                        <div class="card course-card h-100">
                            <img src="{{ asset('assets/Bootcamp.jpg') }}" class="card-img-top" alt="Digital Marketing">
                            <div class="card-body">
                                <h6 class="card-title">Data Science Bootcamp: Python & Machine Learning</h6>
                                <div class="mb-2 text-muted small">
                                    <i class="fas fa-calendar me-1"></i> Mulai: 15 November 2025
                                </div>
                                <div class="fw-bold">
                                    <span class="text-primary">Rp 799.000</span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp 1.500.000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Program 3 -->
                <div class="col-md-4">
                    <a href="{{ route('deskripsi_bootcamp') }}" class="text-decoration-none">
                        <div class="card course-card h-100">
                            <img src="{{ asset('assets/Bootcamp.jpg') }}" class="card-img-top" alt="Digital Marketing">
                            <div class="card-body">
                                <h6 class="card-title">UI/UX Design Masterclass: Figma & Prototyping</h6>
                                <div class="mb-2 text-muted small">
                                    <i class="fas fa-calendar me-1"></i> Mulai: 5 Desember 2025
                                </div>
                                <div class="fw-bold">
                                    <span class="text-primary">Rp 650.000</span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp 1.200.000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary btn-lg">Lihat Semua Program <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- Corporate Section -->
    <section class="corporate-section">
        <div class="container text-center">
            <h2><i class="fas fa-building me-2"></i> E-learning & Training Untuk Perusahaan</h2>
            <p>Miliki akses ratusan konten e-learning LearnServe serta dukungan corporate training untuk perusahaan.</p>
            
            <div class="row g-4 my-4">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo">Microsoft</div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo">Mandiri</div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo">BI</div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo">Mizan</div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo">Tokopedia</div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo">Gojek</div>
                </div>
            </div>
            
            <a href="#" class="btn btn-warning mt-4"><i class="fas fa-phone me-2"></i> Hubungi Tim LearnServe</a>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animasi untuk statistik
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi counter untuk stats section
        const counters = document.querySelectorAll('.stats-section h3');
        const speed = 200;
        
        counters.forEach(counter => {
            const target = parseInt(counter.innerText.replace('+', ''));
            let count = 0;
            
            // Hanya animasi jika elemen terlihat di viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const updateCount = () => {
                            const increment = target / speed;
                            
                            if (count < target) {
                                count += increment;
                                counter.innerText = Math.ceil(count) + (counter.innerText.includes('+') ? '+' : '');
                                setTimeout(updateCount, 1);
                            } else {
                                counter.innerText = target + (counter.innerText.includes('+') ? '+' : '');
                            }
                        };
                        
                        updateCount();
                        observer.unobserve(counter);
                    }
                });
            });
            
            observer.observe(counter);
        });
    });
</script>
@endsection