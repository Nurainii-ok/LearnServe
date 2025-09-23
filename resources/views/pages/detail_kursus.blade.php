@extends('layouts.app')

@section('title', $class ? $class->title : 'Detail Kursus')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/detail_kursus.css') }}">
@endsection

@section('content')



{{-- Hero Section --}}
@if($class->price > 0)
<div class="course-hero text-dark py-5" style="background-color: #d6baa361;">
  <div class="container">

    {{-- Breadcrumb --}}
    <!--<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#" class="text-decoration-none text-info">Development</a>
        </li>
        <li class="breadcrumb-item">
          <a href="#" class="text-decoration-none text-info">{{ $class->category ?? 'Kategori' }}</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">
          {{ $class->subcategory ?? 'Subkategori' }}
        </li>
      </ol>
    </nav>-->

    {{-- Judul --}}
    <h1 class="fw-bold mb-3">{{ $class->title }}</h1>
    <p class="lead">{{ $class->short_description }}</p>

    {{-- Badge + Rating --}}
    <div class="d-flex align-items-center mb-3">
      @if($class->is_bestseller)
        <span class="badge bg-success text-dark me-2">Bestseller</span>
      @endif
      <span>⭐ {{ $class->rating }} ({{ $class->reviews_count }} rating) • {{ $class->students_count }} peserta</span>
    </div>

    {{-- Instructor --}}
    <p class="mb-2">
      Dibuat oleh 
      <a href="#" class="fw-bold text-decoration-none text-info">
        {{ $class->instructor }}
      </a>
    </p>

    {{-- Info tambahan --}}
    <div class="text-muted small">
      <i class="bi bi-clock-history"></i> Update terakhir {{ $class->last_update }} &nbsp;•&nbsp;
      <i class="bi bi-globe"></i> {{ $class->language }} &nbsp;•&nbsp;
      <i class="bi bi-translate"></i> {{ $class->subtitles_count ?? '0' }} subtitle
    </div>

  </div>
</div>
@endif

{{-- Konten Detail --}}
<div class="container my-5">

  {{-- Jika kursus berbayar --}}
  @if($class->price > 0) 
    <div class="row">
      <!-- Deskripsi -->
      <div class="col-lg-8">

        {{-- Deskripsi Kursus --}}
        <div class="mt-4">
          <h4 class="fw-bold">Deskripsi Kursus</h4>
          <p>{{ $class->description }}</p>
        </div>

        {{-- Instruktur --}}
        <div class="mt-4">
          <h4 class="fw-bold">Instruktur</h4>
          <div class="d-flex align-items-center">
            <img src="{{ $class->instructor_image }}" 
                 class="rounded-circle me-3" 
                 alt="Instructor" 
                 style="width:80px;height:80px;object-fit:cover;">
            <div>
              <a href="#" class="fw-bold text-decoration-none">{{ $class->instructor }}</a>
              <p class="mb-1 text-muted">{{ $class->instructor_job }}</p>
              <span class="text-warning">★ {{ $class->rating }}</span> 
              <span class="text-muted">Peringkat Instruktur</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar Harga -->
      <div class="col-lg-4">
        <div class="card sidebar-card shadow-sm border-0 sticky-top" style="top: 100px;">
          <div class="card-body">
            <h3 class="fw-bold" style="color:#944e25;">
              Rp{{ number_format($class->price) }}
              @if($class->original_price > $class->price)
                <small class="text-muted text-decoration-line-through fs-6">
                  Rp{{ number_format($class->original_price) }}
                </small>
              @endif
            </h3>

            @if($class->discount)
              <p style="color:#944e25; font-weight:600;">Diskon {{ $class->discount }}%</p>
            @endif

            @php
                $isEnrolled = false;
                $hasValidPayment = false;
                
                if (session('user_id')) {
                    // Check if user is enrolled
                    $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                  ->where('class_id', $class->id)
                                  ->where('type', 'class')
                                  ->where('status', 'active')
                                  ->exists();
                    
                    // Check if user has valid payment
                    $hasValidPayment = \App\Models\Payment::where('user_id', session('user_id'))
                                       ->where('class_id', $class->id)
                                       ->where('status', 'settlement')
                                       ->exists();
                }
            @endphp
            
            @if($isEnrolled && $hasValidPayment)
                <a href="{{ route('elearning.class', $class->id) }}" 
                   class="btn w-100 fw-bold mb-3" 
                   style="background-color:#28a745; color:white; border:none;">
                  <i class="fas fa-play-circle me-2"></i>Ikuti Classes
                </a>
            @elseif($hasValidPayment && !$isEnrolled)
                <div class="alert alert-info text-center mb-3">
                    <i class="fas fa-clock me-2"></i>
                    <small>Enrollment sedang diproses. Silakan cek kembali dalam beberapa menit.</small>
                </div>
                <a href="{{ route('checkout', $class->id) }}" 
                   class="btn w-100 fw-bold mb-3" 
                   style="background-color:#944e25; color:white; border:none;">
                  <i class="fas fa-credit-card me-2"></i>Beli Sekarang
                </a>
            @else
                <a href="{{ route('checkout', $class->id) }}" 
                   class="btn w-100 fw-bold mb-3" 
                   style="background-color:#944e25; color:white; border:none;">
                  <i class="fas fa-credit-card me-2"></i>Beli Sekarang
                </a>
            @endif

            <hr>
            <h6 class="fw-bold mb-3" style="color:#944e25;">Kursus ini mencakup:</h6>
            <ul class="list-unstyled small mb-4" style="color:#333;">
              <li>📺 {{ $class->duration }} jam video on-demand</li>
              <li>📱 Akses di perangkat seluler dan TV</li>
              <li>♾️ Akses penuh seumur hidup</li>
              <li>🏆 Sertifikat penyelesaian</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  {{-- Jika kursus gratis --}}
  @else 
    <div class="row g-4">
      <!-- Video Preview -->
      <div class="col-lg-7">
        <div class="ratio ratio-16x9 border rounded">
          @if(Str::contains($class->preview_url, 'youtube.com') || Str::contains($class->preview_url, 'vimeo.com'))
            <iframe src="{{ $class->preview_url }}" title="Course Preview" allowfullscreen></iframe>
          @else
            <video controls poster="{{ $class->thumbnail }}">
              <source src="{{ asset('storage/videos/' . $class->preview_url) }}" type="video/mp4">
              Browser kamu tidak mendukung video tag.
            </video>
          @endif
        </div>
      </div>

      <!-- Info & Harga -->
      <div class="col-lg-5">
        <h3 class="fw-bold">{{ $class->title }}</h3>
        <p class="text-muted">{{ $class->short_description }}</p>
        
        <span class="badge bg-success mb-2">Tutorial Gratis</span>
        <div class="d-flex align-items-center mb-2">
          <span class="fw-bold text-warning">★ {{ $class->rating }}</span>
          <span class="ms-2 text-muted">({{ $class->reviews_count }} rating) • {{ $class->students_count }} peserta</span>
        </div>

        <p class="mb-1 text-muted">
          Dibuat oleh <a href="#" class="text-decoration-none">{{ $class->instructor }}</a>
        </p>
        <p class="text-muted">
          <i class="bi bi-globe"></i> {{ $class->language }}
        </p>

        <h5 class="fw-bold text-success">Gratis</h5>
        <a href="{{ route('detail_kursus', $class->id) }}" class="btn btn-outline-primary w-100">Daftar Sekarang</a>
      </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mt-5" id="courseTabs">
      <li class="nav-item"><a class="nav-link active" href="#">Yang akan Anda pelajari</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Konten kursus</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Ulasan</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Instruktur</a></li>
    </ul>

    <!-- Instructor -->
    <div class="mt-4">
      <h5 class="fw-bold">Instruktur</h5>
      <div class="d-flex align-items-center">
        <img src="{{ $class->instructor_image }}" 
             class="rounded-circle me-3" 
             alt="Instructor" 
             style="width:80px;height:80px;object-fit:cover;">
        <div>
          <a href="#" class="fw-bold text-decoration-none">{{ $class->instructor }}</a>
          <p class="mb-1 text-muted">{{ $class->instructor_job }}</p>
          <span class="text-warning">★ {{ $class->rating }}</span> 
          <span class="text-muted">Peringkat Instruktur</span>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
