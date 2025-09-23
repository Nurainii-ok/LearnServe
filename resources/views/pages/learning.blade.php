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
                    <h3 class="fw-bold text-warning">{{ $classes->total() ?? 0 }}+</h3>
                    <p class="small text-muted">Kursus</p>
                </div>
                <div class="col-4">
                    <h3 class="fw-bold text-warning">95%</h3>
                    <p class="small text-muted">Job Placement</p>
                </div>
                <div class="col-4">
                    <h3 class="fw-bold text-warning">{{ $categories->count() }}+</h3>
                    <p class="small text-muted">Kategori</p>
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
                <a href="{{ route('learning') }}" class="btn btn-sm {{ !request('category') || request('category') == 'all' ? 'btn-warning text-white' : 'btn-outline-secondary' }}">Semua Kelas</a>
                @foreach($categories as $category)
                <a href="{{ route('learning', ['category' => $category]) }}" class="btn btn-sm {{ request('category') == $category ? 'btn-warning text-white' : 'btn-outline-secondary' }}">{{ ucfirst($category) }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="GET" action="{{ route('learning') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="{{ request('search') }}">
                        @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <button class="btn btn-warning text-white" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kelas -->
    <section id="courses" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    @if(request('category') && request('category') != 'all')
                        {{ ucfirst(request('category')) }} Kelas
                    @elseif(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @else
                        Semua Kelas
                    @endif
                </h2>
                <span class="text-muted">{{ $classes->total() }} kursus ditemukan</span>
            </div>

            <div class="row g-4">
                @forelse($classes as $class)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('detail_kursus', ['id' => $class->id]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 course-card">
                                <img src="{{ $class->image ? asset($class->image) : asset('assets/Full Stack.jpg') }}" 
                                     alt="{{ $class->title }}" 
                                     class="card-img-top"
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    @if($class->category)
                                    <h6 class="text-warning text-uppercase small fw-bold">{{ $class->category }}</h6>
                                    @endif
                                    <h5 class="fw-bold mb-2">{{ $class->title }}</h5>
                                    <p class="text-muted small mb-3">{{ Str::limit($class->description, 80) }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="text-muted small">
                                            @if($class->tutor)
                                            <i class="fas fa-user"></i> {{ $class->tutor->name }}
                                            @endif
                                        </div>
                                        <span class="text-warning">⭐ 4.7</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($class->price > 0)
                                            <span class="fw-bold text-brown">Rp {{ number_format($class->price, 0, ',', '.') }}</span>
                                            @else
                                            <span class="fw-bold text-success">Gratis</span>
                                            @endif
                                        </div>
                                        <div class="text-muted small">
                                            @if($class->start_date)
                                            <i class="fas fa-calendar"></i> {{ $class->start_date->format('d M Y') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            @if(request('search'))
                                Tidak ada kursus yang ditemukan untuk pencarian "{{ request('search') }}".
                            @elseif(request('category'))
                                Belum ada kursus untuk kategori "{{ request('category') }}".
                            @else
                                Belum ada kursus yang tersedia saat ini.
                            @endif
                        </div>
                        @if(request('search') || request('category'))
                        <a href="{{ route('learning') }}" class="btn btn-warning text-white">Lihat Semua Kelas</a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($classes->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $classes->appends(request()->except('page'))->links() }}
            </div>
            @endif
        </div>
    </section>

@section('scripts')
<script>
    // Script untuk menangani filter kategori
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.category-filter a');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Update active state will be handled by server-side rendering
            });
        });
    });
</script>
@endsection
@endsection