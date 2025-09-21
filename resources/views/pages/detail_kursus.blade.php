@extends('layouts.app')

@section('title', $class ? $class->title : 'Detail Kursus')

@section('content')
<div class="container my-5">

  {{-- Jika kursus berbayar --}}
  @if($class->price > 0) 
    <div class="row">
      <div class="col-lg-8">
        <!-- Judul & Info Kursus -->
        <h1 class="fw-bold mb-3">{{ $class->title }}</h1>
        <p class="lead text-muted">{{ $class->short_description }}</p>

<<<<<<< HEAD
  <div class="row">
    <!-- Konten Kiri -->
    <div class="col-lg-8">
      <!-- Judul & Info Kursus -->
      <h1 class="fw-bold mb-3">{{ $class ? $class->title : 'Full Stack Web Development' }}</h1>
      <p class="lead text-muted">{{ $class ? $class->description : 'Belajar membuat website modern dengan teknologi terbaru dari frontend hingga backend secara komprehensif.' }}</p>
=======
        <div class="d-flex align-items-center mb-3">
          <span class="badge bg-warning text-dark me-2">Best Seller</span>
          <span>⭐ {{ $class->rating }} ({{ $class->reviews_count }} rating) • {{ $class->students_count }} peserta</span>
        </div>
>>>>>>> 0e46bc39732e8c47debf144f5398fc5addfd7892

        <p><i class="bi bi-globe"></i> {{ $class->language }} • 
           <i class="bi bi-clock-history"></i> Update terakhir {{ $class->last_update }}</p>

        {{-- Konten kursus, persyaratan, deskripsi, dll --}}
        <div class="mt-4">
          <h4 class="fw-bold">Deskripsi Kursus</h4>
          <p>{{ $class->description }}</p>
        </div>

        <div class="mt-4">
          <h4 class="fw-bold">Instruktur</h4>
          <div class="d-flex align-items-center">
            <img src="{{ $class->instructor_image }}" class="rounded-circle me-3" 
                 alt="Instructor" style="width:80px;height:80px;object-fit:cover;">
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
        <div class="card shadow-sm border-0 sticky-top" style="top: 100px; background-color:#f3efec;">
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

            <a href="{{ route('checkout', $class->id) }}" 
               class="btn w-100 fw-bold mb-3" 
               style="background-color:#944e25; color:white; border:none;">
                <i class="fas fa-credit-card me-2"></i>Beli Sekarang
            </a>

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
              {{-- Embed YouTube/Vimeo --}}
              <iframe src="{{ $class->preview_url }}" 
                      title="Course Preview" allowfullscreen></iframe>
          @else
              {{-- Video lokal / file upload --}}
              <video controls>
                <source src="{{ asset('storage/videos/' . $class->preview_url) }}" type="video/mp4">
                Browser kamu tidak mendukung video tag.
              </video>
          @endif
        </div>
      </div>

<<<<<<< HEAD
      <!-- Harga -->
      <h3 class="fw-bold" style="color:#944e25;">
        @if($class)
          @if($class->price > 0)
            Rp{{ number_format($class->price, 0, ',', '.') }}
          @else
            <span class="text-success">GRATIS</span>
          @endif
        @else
          Rp139.000 
        @endif
        <small class="text-muted text-decoration-line-through fs-6">Rp169.000</small>
      </h3>
      <p style="color:#944e25; font-weight:600;">Diskon 18%</p>
      <!--<p style="color:#d9534f;"><i class="bi bi-alarm"></i> 14 jam lagi dengan harga ini!</p>-->

      <!-- Tombol -->
      @if(session('user_id'))
        @php
          $isEnrolled = false;
          if($class && session('user_id')) {
            $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                          ->where('class_id', $class->id)
                          ->where('type', 'class')
                          ->exists();
          }
        @endphp
        
        @if($isEnrolled)
          <div class="alert alert-success mb-3">
            <i class="fas fa-check-circle me-2"></i>
            Anda sudah terdaftar di kelas ini
          </div>
          <a href="{{ route('elearning.class', $class->id) }}" 
             class="btn w-100 fw-bold mb-3" 
             style="background-color:#28a745; color:white; border:none;">
              <i class="fas fa-play-circle me-2"></i>Ikuti Course
          </a>
        @else
          <!-- Original Beli Sekarang Button with Midtrans -->
          <a href="{{ route('checkout', ['class_id' => $class ? $class->id : null]) }}" 
             class="btn w-100 fw-bold mb-3" 
             style="background-color:#944e25; color:white; border:none;">
              <i class="fas fa-credit-card me-2"></i>Beli Sekarang
          </a>
          
          <!-- Alternative: Quick Enroll (if free or for quick access) -->
          @if($class && $class->price == 0)
            <form action="{{ route('enrollment.class', $class->id) }}" method="POST" class="mb-3">
              @csrf
              <button type="submit" 
                      class="btn w-100 fw-bold btn-outline-success" 
                      style="border-color:#28a745;">
                  <i class="fas fa-user-plus me-2"></i>Daftar Gratis
              </button>
            </form>
          @endif
        @endif
      @else
        <div class="alert alert-warning mb-3">
          <i class="fas fa-info-circle me-2"></i>
          Silakan <a href="{{ route('auth') }}" class="alert-link">login</a> untuk membeli kelas
        </div>
      @endif


      <!--<p class="text-center small" style="color:#944e25;">Jaminan Uang Kembali 30 Hari</p>-->
      <hr>

      <!-- Fitur -->
      <h6 class="fw-bold mb-3" style="color:#944e25;">Kursus ini mencakup:</h6>
      <ul class="list-unstyled small mb-4" style="color:#333;">
        <li>📺 43 jam video on-demand</li>
        <li>📄 10 artikel</li>
        <li>📱 Akses di perangkat seluler dan TV</li>
        <li>♾️ Akses penuh seumur hidup</li>
        <li>🏆 Sertifikat penyelesaian</li>
      </ul>

      <hr>

      <!-- Kupon -->
      <!--<h6 class="fw-bold" style="color:#944e25;">Gunakan Kupon</h6>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Masukkan Kupon" style="border-color:#944e25;">
        <button class="btn" style="background-color:#ecac57; color:#fff; border:none;">Terapkan</button>
      </div>-->
=======
      <!-- Info Kursus -->
      <div class="col-lg-5">
        <h3 class="fw-bold">{{ $class->title }}</h3>
        <p class="text-muted">{{ $class->short_description }}</p>
        
        <span class="badge bg-success mb-2">Tutorial Gratis</span>
        <div class="d-flex align-items-center mb-2">
          <span class="fw-bold text-warning">★ {{ $class->rating }}</span>
          <span class="ms-2 text-muted">({{ $class->reviews_count }} rating) • {{ $class->students_count }} peserta</span>
        </div>

        <p class="mb-1 text-muted">Dibuat oleh <a href="#" class="text-decoration-none">{{ $class->instructor }}</a></p>
        <p class="text-muted"><i class="bi bi-globe"></i> {{ $class->language }}</p>
>>>>>>> 0e46bc39732e8c47debf144f5398fc5addfd7892

        <h5 class="fw-bold">Gratis</h5>
        <a href="{{ route('detail_kursus', $class->id) }}" 
           class="btn btn-outline-primary w-100">Daftar Sekarang</a>
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
        <img src="{{ $class->instructor_image }}" class="rounded-circle me-3" 
             alt="Instructor" style="width:80px;height:80px;object-fit:cover;">
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
