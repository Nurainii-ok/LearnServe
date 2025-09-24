@extends('layouts.app')

@section('title', 'Bootcamp & Program')

{{-- CSS --}}
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                    <img src="{{ asset('assets/img/illustrations/Bootcamp_org.jpg') }}" alt="Bootcamp" class="img-fluid">
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
                @forelse($bootcamps as $bootcamp)
                    <!-- Program {{ $loop->iteration }} -->
                    <div class="col-md-4">
                        <a href="{{ route('deskripsi_bootcamp', ['id' => $bootcamp->id]) }}" class="text-decoration-none">
                            <div class="card course-card h-100 border-0 shadow-sm">
                                <!-- Image with consistent height -->
                                <div class="position-relative">
                                    <img src="{{ $bootcamp->image ? asset($bootcamp->image) : asset('assets/Bootcamp.jpg') }}" 
                                         class="card-img-top" alt="{{ $bootcamp->title }}" 
                                         style="height: 200px; object-fit: cover;">
                                    
                                    <!-- Rating badge (optional) -->
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success">
                                            <i class="fas fa-star"></i> Rating 4.5/5
                                        </span>
                                    </div>
                                    
                                    <!-- Alumni count badge -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-info">
                                            <i class="fas fa-users"></i> 10.000+ Alumni
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    <!-- Title -->
                                    <h6 class="card-title fw-bold text-dark mb-3" style="min-height: 48px; line-height: 1.4;">
                                        {{ Str::upper($bootcamp->title) }}
                                    </h6>
                                    
                                    <!-- Date -->
                                    <div class="mb-3 text-muted">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        <span class="fw-medium">{{ $bootcamp->start_date->format('d M Y') }}</span>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($bootcamp->price > 0)
                                                <div class="text-primary fw-bold fs-5">
                                                    Rp {{ number_format($bootcamp->price, 0, ',', '.') }}
                                                </div>
                                                <!-- Optional: Show original price if there's a discount -->
                                                @if($bootcamp->original_price && $bootcamp->original_price > $bootcamp->price)
                                                    <small class="text-muted text-decoration-line-through">
                                                        Rp {{ number_format($bootcamp->original_price, 0, ',', '.') }}
                                                    </small>
                                                @endif
                                            @else
                                                <div class="text-success fw-bold fs-5">
                                                    GRATIS
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- CTA Arrow or Icon -->
                                        <!--<div class="text-primary">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>-->
                                    </div>
                                </div>
                                
                                <!-- Bottom CTA Button -->
                                <!--<div class="card-footer border-0 bg-transparent p-4 pt-0">
                                    <div class="btn btn-primary w-100 fw-medium">
                                        <i class="fas fa-bolt me-2"></i>
                                        Daftar Sekarang
                                    </div>
                                </div>-->
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada program bootcamp yang tersedia saat ini.
                        </div>
                    </div>
                @endforelse
            </div>

            <!--<div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary btn-lg">Lihat Semua Program <i class="fas fa-arrow-right ms-2"></i></a>
            </div>-->
        </div>
    </section>

    <!-- Corporate Section -->
    <!--<section class="corporate-section">
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
    </section>-->
@endsection

@section('scripts')
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