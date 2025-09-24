@extends('layouts.app')

@section('title', $bootcamp ? $bootcamp->title : 'Deskripsi Bootcamp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/deskripsi_bootcamp.css') }}">
@endpush

@section('content')

@if($bootcamp)
    {{-- Hero Section --}}
{{-- Hero Section - Fixed with Background Color --}}
<section class="py-5 hero-section" style="background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);">
    <div class="container">
        <div class="row align-items-center g-4">
            <!-- Gambar dengan ukuran konsisten -->
            <div class="col-md-6">
                <div class="hero-image-container" style="height: 400px; overflow: hidden; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <img src="{{ $bootcamp->image ? asset($bootcamp->image) : asset('assets/Bootcamp.jpg') }}" 
                         alt="{{ $bootcamp->title }}" 
                         class="img-fluid w-100 h-100" 
                         style="object-fit: cover; object-position: center;">
                </div>
            </div>

            <!-- Konten - Hanya info dasar bootcamp -->
            <div class="col-md-6 hero-content">
                <div class="card shadow-lg border-0" style="border-radius: 15px; backdrop-filter: blur(10px); background: rgba(255,255,255,0.95);">
                    <div class="card-body p-4">
                        <h2 class="text-primary fw-semibold mb-2">
                            {{ $bootcamp->title }}
                        </h2>
                        
                        <!-- Pricing dengan styling yang lebih menarik -->
                        @if($bootcamp->price > 0)
                            <div class="price-tag mb-3">
                                Rp {{ number_format($bootcamp->price, 0, ',', '.') }}
                            </div>
                        @else
                            <div class="price-tag price-free mb-3">
                                Rp 50.000
                            </div>
                        @endif
                        
                        <!-- Meta Information dengan icon yang lebih terstruktur -->
                        <div class="meta-info mb-2">
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $bootcamp->start_date->format('d M Y') }} – {{ $bootcamp->end_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="meta-info mb-2">
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>Durasi: {{ $bootcamp->duration }}</span>
                            </div>
                        </div>

                        @if($bootcamp->tutor)
                        <div class="meta-info mb-2">
                            <div class="meta-item">
                                <i class="fas fa-user-graduate"></i>
                                <span>Tutor: {{ $bootcamp->tutor->name }}</span>
                            </div>
                        </div>
                        @endif

                        @if($bootcamp->level)
                        <div class="meta-info mb-2">
                            <div class="meta-item">
                                <i class="fas fa-layer-group"></i>
                                <span>Level: 
                                    <span class="badge bg-{{ $bootcamp->level == 'beginner' ? 'success' : ($bootcamp->level == 'intermediate' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($bootcamp->level) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        @endif

                        @if($bootcamp->category)
                        <div class="meta-info mb-3">
                            <div class="meta-item">
                                <i class="fas fa-tags"></i>
                                <span>Kategori: <span class="badge bg-primary">{{ $bootcamp->category }}</span></span>
                            </div>
                        </div>
                        @endif

                        <!-- Action Button -->
                        @if(session('user_id'))
                            @php
                                $isEnrolled = false;
                                if($bootcamp && session('user_id')) {
                                    $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                                  ->where('bootcamp_id', $bootcamp->id)
                                                  ->where('type', 'bootcamp')
                                                  ->exists();
                                }
                            @endphp
                            
                            @if($isEnrolled)
                                <a href="{{ route('member.dashboard') }}" class="btn btn-success w-100">
                                    <i class="fas fa-graduation-cap me-2"></i> Ke Dashboard Belajar
                                </a>
                            @else
                                @if($bootcamp->price > 0)
                                    {{-- Bootcamp berbayar - ke checkout --}}
                                    <a href="{{ route('checkout') }}?bootcamp_id={{ $bootcamp->id }}" class="btn btn-warning w-100">
                                        <i class="fas fa-bolt me-2"></i> Daftar Sekarang
                                    </a>
                                @else
                                    {{-- Bootcamp gratis - langsung enrollment --}}
                                    <form action="{{ route('enrollment.bootcamp', $bootcamp->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning w-100">
                                            <i class="fas fa-bolt me-2"></i> Daftar Sekarang
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('auth') }}" class="btn btn-warning w-100">
                                Login untuk Daftar
                            </a>
                        @endif

                        <!-- Kapasitas Info -->
                        @if($bootcamp->capacity)
                        <p class="text-muted small mt-2 mb-0">
                            <i class="fas fa-users me-2"></i>
                            Kapasitas: {{ $bootcamp->capacity }} peserta
                            @if($bootcamp->enrolled)
                                ({{ $bootcamp->enrolled }} terdaftar)
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Section baru untuk konten yang dipindahkan dari hero --}}
<section class="py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-6 fw-bold mb-3">{{ $bootcamp->title }}</h1>
                
                @if(session('user_id'))
                    @php
                        $isEnrolled = false;
                        if($bootcamp && session('user_id')) {
                            $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                          ->where('bootcamp_id', $bootcamp->id)
                                          ->where('type', 'bootcamp')
                                          ->exists();
                        }
                    @endphp
                    
                    @if($isEnrolled)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Anda sudah terdaftar di bootcamp ini
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        Silakan <a href="{{ route('auth') }}" class="alert-link fw-semibold">login</a> untuk mendaftar bootcamp
                    </div>
                @endif

                <!-- Alumni Info -->
                <p class="text-muted">
                    @if($bootcamp->capacity)
                        <i class="fas fa-users me-2"></i>
                        Kapasitas: {{ $bootcamp->capacity }} peserta
                        @if($bootcamp->enrolled)
                            ({{ $bootcamp->enrolled }} terdaftar)
                        @endif
                    @else
                        <i class="fas fa-star me-2"></i>
                        5.000+ Alumni Bootcamp Tiap Bulan
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>

    {{-- Content Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">

                {{-- Sidebar --}}
                <aside class="col-md-3">
                    <div class="card shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Detail Bootcamp</h5>
                            
                            <!-- Bootcamp Info -->
                            <div class="mb-3">
                                @if($bootcamp->level)
                                <div class="mb-2">
                                    <small class="text-muted d-block">Level:</small>
                                    <span class="badge bg-{{ $bootcamp->level == 'beginner' ? 'success' : ($bootcamp->level == 'intermediate' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($bootcamp->level) }}
                                    </span>
                                </div>
                                @endif
                                
                                @if($bootcamp->category)
                                <div class="mb-2">
                                    <small class="text-muted d-block">Kategori:</small>
                                    <span class="badge bg-primary">{{ $bootcamp->category }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <ul class="nav flex-column small" id="sidebar-nav">
                                <li class="nav-item"><a href="#tentang" class="nav-link">Tentang Bootcamp</a></li>
                                <li class="nav-item"><a href="#prospek" class="nav-link">Prospek Karir</a></li>
                                <li class="nav-item"><a href="#skill" class="nav-link">Skill Yang Akan Kamu Miliki</a></li>
                                <li class="nav-item"><a href="#benefit" class="nav-link">Benefit Bootcamp</a></li>
                                <li class="nav-item"><a href="#kurikulum" class="nav-link">Kurikulum & Silabus</a></li>
                                @if($bootcamp->requirements)
                                <li class="nav-item"><a href="#requirements" class="nav-link">Persyaratan</a></li>
                                @endif
                                <li class="nav-item"><a href="#testimoni" class="nav-link">Testimoni</a></li>
                            </ul>
                            @if(session('user_id'))
                                @php
                                    $sidebarEnrolled = false;
                                    if($bootcamp && session('user_id')) {
                                        $sidebarEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                                          ->where('bootcamp_id', $bootcamp->id)
                                                          ->where('type', 'bootcamp')
                                                          ->exists();
                                    }
                                @endphp
                                
                                @if($sidebarEnrolled)
                                    <a href="{{ route('elearning.bootcamp', $bootcamp->id) }}" 
                                       class="btn btn-success w-100 mt-4">
                                        <i class="fas fa-play-circle me-2"></i>Ikuti Course
                                    </a>
                                @else
                                    @if($bootcamp->price > 0)
                                        {{-- Bootcamp berbayar - ke checkout --}}
                                        <a href="{{ route('checkout') }}?bootcamp_id={{ $bootcamp->id }}" 
                                           class="btn btn-warning w-100 mt-4">
                                            ⚡ Daftar Sekarang
                                        </a>
                                    @else
                                        {{-- Bootcamp gratis - langsung enrollment --}}
                                        <form action="{{ route('enrollment.bootcamp', $bootcamp->id) }}" method="POST" class="mt-4">
                                            @csrf
                                            <button type="submit" class="btn btn-warning w-100">
                                                ⚡ Daftar Sekarang (Gratis)
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('auth') }}" 
                                   class="btn btn-warning w-100 mt-4">
                                    Login untuk Daftar
                                </a>
                            @endif
                        </div>
                    </div>
                </aside>

                {{-- Main Content --}}
                <main class="col-md-9">
                    <div class="card shadow-sm mb-4" id="tentang">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Tentang Bootcamp</h5>
                            <div class="mb-3">
                                <h6 class="fw-semibold">{{ $bootcamp->title }}</h6>
                                <p class="text-muted">{{ $bootcamp->description }}</p>
                            </div>
                            
                            @if($bootcamp->requirements)
                            <div class="alert alert-info" id="requirements">
                                <h6 class="fw-semibold mb-2"><i class="fas fa-info-circle me-2"></i>Persyaratan</h6>
                                <p class="mb-0">{{ $bootcamp->requirements }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="prospek">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Prospek Karir</h5>
                            <p class="text-muted">
                                Setelah menyelesaikan bootcamp {{ $bootcamp->title }}, Anda akan memiliki kemampuan yang dibutuhkan industri. 
                                @if($bootcamp->category == 'Web Development')
                                    Prospek karir meliputi Frontend Developer, Backend Developer, Full Stack Developer, UI/UX Designer, dan Software Engineer dengan gaji rata-rata Rp 8-25 juta per bulan.
                                @elseif($bootcamp->category == 'Data Science')
                                    Prospek karir meliputi Data Scientist, Data Analyst, Machine Learning Engineer, Business Intelligence Analyst, dan Data Engineer dengan gaji rata-rata Rp 12-35 juta per bulan.
                                @elseif($bootcamp->category == 'Digital Marketing')
                                    Prospek karir meliputi Digital Marketing Specialist, Social Media Manager, SEO Specialist, Content Creator, dan Marketing Analyst dengan gaji rata-rata Rp 6-20 juta per bulan.
                                @elseif($bootcamp->category == 'Design')
                                    Prospek karir meliputi UI/UX Designer, Product Designer, Visual Designer, Graphic Designer, dan Design System Designer dengan gaji rata-rata Rp 7-22 juta per bulan.
                                @else
                                    Prospek karir sangat luas dan menjanjikan di era digital ini. Banyak perusahaan membutuhkan talenta dengan skill yang akan Anda pelajari.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="skill">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Skill Yang Akan Kamu Miliki</h5>
                            <p class="text-muted mb-3">
                                Setelah menyelesaikan bootcamp {{ $bootcamp->title }}, Anda akan menguasai berbagai skill praktis yang langsung bisa diterapkan di dunia kerja.
                            </p>
                            
                            @if($bootcamp->category == 'Web Development')
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> HTML, CSS, dan JavaScript</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Framework modern (React, Vue, atau Angular)</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Backend development (Node.js, PHP, atau Python)</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Database management (MySQL, MongoDB)</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Version control dengan Git</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Deployment dan hosting</li>
                            </ul>
                            @elseif($bootcamp->category == 'Data Science')
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Python untuk data science</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Pandas, NumPy, dan Matplotlib</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Machine Learning dengan Scikit-learn</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Deep Learning dengan TensorFlow</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Data visualization dengan Tableau</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> SQL dan database analytics</li>
                            </ul>
                            @elseif($bootcamp->category == 'Digital Marketing')
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Social Media Marketing Strategy</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Google Ads dan Facebook Ads</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Search Engine Optimization (SEO)</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Content Marketing dan Copywriting</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Email Marketing automation</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Analytics dan performance tracking</li>
                            </ul>
                            @elseif($bootcamp->category == 'Design')
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Design thinking dan user research</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Figma dan Adobe Creative Suite</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Wireframing dan prototyping</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> User interface (UI) design</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> User experience (UX) design</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Design system dan style guide</li>
                            </ul>
                            @else
                            <p class="text-muted">
                                Skill praktis yang relevan dengan industry trends terkini, dengan focus pada hands-on practice dan real-world projects.
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="benefit">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Benefit Bootcamp</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-certificate text-warning me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Sertifikat Resmi</h6>
                                            <p class="text-muted small mb-0">Dapatkan sertifikat yang diakui industri setelah menyelesaikan bootcamp.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-users text-warning me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Mentoring 1-on-1</h6>
                                            <p class="text-muted small mb-0">Bimbingan personal dari mentor berpengalaman di industri.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-project-diagram text-warning me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Portfolio Projects</h6>
                                            <p class="text-muted small mb-0">Kerjakan project real-world untuk memperkuat portfolio Anda.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-briefcase text-warning me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Job Placement</h6>
                                            <p class="text-muted small mb-0">Bantuan penempatan kerja dengan network partner perusahaan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="kurikulum">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Kurikulum & Silabus</h5>
                            <p class="text-muted mb-3">
                                Kurikulum dirancang komprehensif dengan durasi {{ $bootcamp->duration }}, 
                                menggabungkan teori dan praktik langsung.
                            </p>
                            
                            @if($bootcamp->category == 'Web Development')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="fw-semibold text-primary">Module 1-2: Frontend Basics</h6>
                                        <ul class="small text-muted mb-0">
                                            <li>HTML & CSS Fundamentals</li>
                                            <li>JavaScript ES6+</li>
                                            <li>Responsive Design</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="fw-semibold text-primary">Module 3-4: Framework</h6>
                                        <ul class="small text-muted mb-0">
                                            <li>React atau Vue.js</li>
                                            <li>State Management</li>
                                            <li>Component Architecture</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="fw-semibold text-primary">Module 5-6: Backend</h6>
                                        <ul class="small text-muted mb-0">
                                            <li>Node.js atau PHP</li>
                                            <li>Database Design</li>
                                            <li>API Development</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="fw-semibold text-primary">Module 7-8: Deployment</h6>
                                        <ul class="small text-muted mb-0">
                                            <li>Git Version Control</li>
                                            <li>Cloud Deployment</li>
                                            <li>Final Project</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-light">
                                <h6 class="fw-semibold mb-2">Kurikulum Terstruktur</h6>
                                <p class="mb-0 text-muted">
                                    Materi pembelajaran disusun secara sistematis dari basic hingga advanced, 
                                    dengan project-based learning dan mentoring intensif.
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="testimoni">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Testimoni Alumni</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <!--<img src="{{ asset('assets/P1.jpg') }}" alt="Alumni" class="rounded-circle" width="60" height="60">
                                            </div>
                                            <p class="small text-muted">"Bootcamp yang sangat terstruktur dan praktis. Mentor sangat membantu dan materinya up-to-date dengan industri."</p>
                                            <span class="fw-semibold">Sarah Putri</span>
                                            <small class="text-muted d-block">Frontend Developer</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <!--<img src="{{ asset('assets/P2.jpg') }}" alt="Alumni" class="rounded-circle" width="60" height="60">-->
                                            </div>
                                            <p class="small text-muted">"Dalam {{ $bootcamp->duration }}, saya berhasil career switch dari non-IT ke tech industry. Portfolio projects sangat membantu!"</p>
                                            <span class="fw-semibold">Ahmad Rizki</span>
                                            <small class="text-muted d-block">{{ $bootcamp->category }} Specialist</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body">
                                            <div class="mb-2">
                                               <!-- <img src="{{ asset('assets/P3.jpg') }}" alt="Alumni" class="rounded-circle" width="60" height="60">-->
                                            </div>
                                            <p class="small text-muted">"Job placement program membantu saya mendapat kerja di startup unicorn. Sangat recommended!"</p>
                                            <span class="fw-semibold">Maya Sari</span>
                                            <small class="text-muted d-block">Junior {{ $bootcamp->category }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>

@else
    {{-- Fallback when no bootcamp ID provided --}}
    <section class="py-5">
        <div class="container text-center">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Bootcamp tidak ditemukan. <a href="{{ route('bootcamp') }}" class="alert-link">Kembali ke halaman bootcamp</a>
            </div>
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sections = document.querySelectorAll("main .card");
        const navLinks = document.querySelectorAll("#sidebar-nav .nav-link");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => link.classList.remove("active"));
                    const activeLink = document.querySelector(`#sidebar-nav a[href="#${entry.target.id}"]`);
                    if (activeLink) {
                        activeLink.classList.add("active");
                    }
                }
            });
        }, { threshold: 0.5 });

        sections.forEach(section => observer.observe(section));
    });
</script>
@endpush