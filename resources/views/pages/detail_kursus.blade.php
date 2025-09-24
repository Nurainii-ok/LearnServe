@extends('layouts.app')

@section('title', $class ? $class->title : 'Detail Kursus')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/detail_kursus.css') }}">
@endsection

@section('content')

{{-- Hero Section --}}
<div class="course-hero text-white py-5" style="background: linear-gradient(135deg, #1c1d1f 0%, #2d2f31 100%);">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        {{-- Judul --}}
        <h1 class="fw-bold mb-3" style="font-size: 2.5rem; line-height: 1.2;">{{ $class->title }}</h1>
        
        {{-- Deskripsi Singkat --}}
        <p class="lead mb-4" style="font-size: 1.25rem; color: #f4f4f5;">{{ $class->short_description }}</p>
        
        {{-- Rating dan Info --}}
        <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
          @if($class->is_bestseller)
            <span class="badge bg-warning text-dark px-3 py-2 fw-bold">🏆 Bestseller</span>
          @endif
          
          <div class="d-flex align-items-center">
            <span class="text-warning fw-bold me-2" style="font-size: 1.1rem;">★ {{ $class->rating }}</span>
            <span class="text-light">({{ number_format($class->reviews_count) }} rating)</span>
          </div>
          
          <span class="text-light">👥 {{ number_format($class->students_count) }} peserta</span>
        </div>

        {{-- Instructor --}}
        <div class="d-flex align-items-center mb-3">
          <span class="text-light me-2">Dibuat oleh</span>
          <a href="#" class="fw-bold text-decoration-none text-warning">{{ $class->instructor }}</a>
        </div>

        {{-- Info tambahan --}}
        <div class="text-light small d-flex align-items-center flex-wrap gap-3">
          <span><i class="bi bi-clock-history me-1"></i> Update terakhir {{ $class->last_update }}</span>
          <span><i class="bi bi-globe me-1"></i> {{ $class->language }}</span>
          <span><i class="bi bi-translate me-1"></i> {{ $class->subtitles_count ?? '0' }} subtitle</span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Main Content --}}
<div class="container my-5">
  <div class="row">
    {{-- Left Column - Course Content --}}
    <div class="col-lg-8">
      
      {{-- Apa Yang Akan Dipelajari --}}
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4" style="color: #1c1d1f;">Apa yang akan Anda pelajari</h4>
          <div class="row">
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li class="mb-3 d-flex">
                  <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                  <span>Memahami konsep dasar {{ $class->title }}</span>
                </li>
                <li class="mb-3 d-flex">
                  <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                  <span>Menguasai teknik-teknik fundamental dalam bidang ini</span>
                </li>
                <li class="mb-3 d-flex">
                  <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                  <span>Dapat menerapkan pengetahuan dalam praktik nyata</span>
                </li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li class="mb-3 d-flex">
                  <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                  <span>Mengembangkan keterampilan analisis dan problem solving</span>
                </li>
                <li class="mb-3 d-flex">
                  <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                  <span>Mempersiapkan diri untuk karir profesional</span>
                </li>
                <li class="mb-3 d-flex">
                  <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                  <span>Mendapatkan sertifikat yang diakui industri</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      {{-- Konten Kursus --}}
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4" style="color: #1c1d1f;">Konten Kursus</h4>
          <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
            <span>{{ $class->sections_count ?? '5' }} bagian • {{ $class->lessons_count ?? '25' }} pelajaran • {{ $class->duration }} jam total</span>
          </div>

          {{-- Course Sections --}}
          <div class="accordion" id="courseAccordion">
            {{-- Section 1: Introduction --}}
            <div class="accordion-item border-0 border-bottom">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#section1">
                  <div class="d-flex justify-content-between w-100 me-3">
                    <span class="fw-semibold">Introduction to {{ $class->title }}</span>
                    <small class="text-muted">5 pelajaran • 20 menit</small>
                  </div>
                </button>
              </h2>
              <div id="section1" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                <div class="accordion-body bg-light">
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-file-text me-3 text-muted"></i>
                      <span>Introduction to Course</span>
                    </div>
                    <small class="text-muted">01:16</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-play-circle me-3 text-muted"></i>
                      <span>What is {{ $class->title }}</span>
                      <span class="badge bg-primary ms-2 small">Preview</span>
                    </div>
                    <small class="text-muted">05:31</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-play-circle me-3 text-muted"></i>
                      <span>Basic Concepts Overview</span>
                      <span class="badge bg-primary ms-2 small">Preview</span>
                    </div>
                    <small class="text-muted">05:50</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-play-circle me-3 text-muted"></i>
                      <span>Understanding the Framework</span>
                      <span class="badge bg-primary ms-2 small">Preview</span>
                    </div>
                    <small class="text-muted">05:15</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-play-circle me-3 text-muted"></i>
                      <span>Setting Up Your Environment</span>
                    </div>
                    <small class="text-muted">02:01</small>
                  </div>
                </div>
              </div>
            </div>

            {{-- Section 2: Fundamentals --}}
            <div class="accordion-item border-0 border-bottom">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#section2">
                  <div class="d-flex justify-content-between w-100 me-3">
                    <span class="fw-semibold">Fundamentals of {{ $class->title }}</span>
                    <small class="text-muted">4 pelajaran • 32 menit</small>
                  </div>
                </button>
              </h2>
              <div id="section2" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                <div class="accordion-body bg-light">
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-play-circle me-3 text-muted"></i>
                      <span>Core Principles</span>
                    </div>
                    <small class="text-muted">08:45</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-play-circle me-3 text-muted"></i>
                      <span>Practical Applications</span>
                    </div>
                    <small class="text-muted">12:30</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-file-text me-3 text-muted"></i>
                      <span>Exercise: Hands-on Practice</span>
                    </div>
                    <small class="text-muted">05:15</small>
                  </div>
                  <div class="lesson-item d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-patch-question me-3 text-muted"></i>
                      <span>Quiz: Test Your Knowledge</span>
                    </div>
                    <small class="text-muted">5 questions</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Persyaratan --}}
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4" style="color: #1c1d1f;">Persyaratan</h4>
          <ul class="list-unstyled">
            <li class="mb-2 d-flex">
              <i class="bi bi-dot me-2 mt-2"></i>
              <span>Tidak diperlukan pengalaman sebelumnya - kami akan mengajarkan dari dasar</span>
            </li>
            <li class="mb-2 d-flex">
              <i class="bi bi-dot me-2 mt-2"></i>
              <span>Komputer dengan akses internet yang stabil</span>
            </li>
            <li class="mb-2 d-flex">
              <i class="bi bi-dot me-2 mt-2"></i>
              <span>Motivasi untuk belajar dan berlatih secara konsisten</span>
            </li>
            <li class="mb-2 d-flex">
              <i class="bi bi-dot me-2 mt-2"></i>
              <span>Browser web modern (Chrome, Firefox, Safari, atau Edge)</span>
            </li>
          </ul>
        </div>
      </div>

      {{-- Deskripsi Lengkap --}}
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4" style="color: #1c1d1f;">Deskripsi Kursus</h4>
          <div class="content-description" style="line-height: 1.7;">
            <p class="mb-4">{{ $class->description }}</p>
            
            <p class="mb-4">
              Kursus ini dirancang khusus untuk memberikan pemahaman yang mendalam tentang {{ $class->title }}. 
              Anda akan belajar dari dasar hingga tingkat lanjut dengan pendekatan praktis dan teori yang seimbang.
            </p>
            
            <h6 class="fw-bold mb-3">Mengapa memilih kursus ini?</h6>
            <p class="mb-4">
              Dengan pengalaman bertahun-tahun dalam bidang ini, instruktur kami telah merancang kurikulum yang 
              komprehensif dan up-to-date. Setiap materi disajikan dengan cara yang mudah dipahami, dilengkapi 
              dengan contoh-contoh praktis dan studi kasus nyata.
            </p>

            <h6 class="fw-bold mb-3">Siapa yang cocok mengikuti kursus ini?</h6>
            <ul class="mb-4">
              <li>Pemula yang ingin mempelajari {{ $class->title }} dari nol</li>
              <li>Profesional yang ingin meningkatkan kemampuan di bidang ini</li>
              <li>Mahasiswa yang membutuhkan pemahaman praktis untuk akademik</li>
              <li>Siapapun yang tertarik untuk mengembangkan karir di bidang ini</li>
            </ul>

            <p class="mb-0">
              Bergabunglah dengan ribuan peserta yang telah merasakan manfaat dari kursus ini. 
              Dapatkan akses seumur hidup dan mulai perjalanan pembelajaran Anda hari ini!
            </p>
          </div>
        </div>
      </div>

      {{-- Instruktur --}}
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4" style="color: #1c1d1f;">Tutor</h4>
          <div class="d-flex align-items-start">
            <img src="{{ $class->instructor_image ?? 'https://via.placeholder.com/120x120' }}" 
                 class="rounded-circle me-4 flex-shrink-0" 
                 alt="Instructor" 
                 style="width:120px;height:120px;object-fit:cover;">
            <div class="flex-grow-1">
              <h5 class="fw-bold mb-2">
                <a href="#" class="text-decoration-none text-dark">{{ $class->instructor }}</a>
              </h5>
              <p class="text-muted mb-3">{{ $class->instructor_job ?? 'Expert Instructor' }}</p>
              
              <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-star-fill text-warning me-2"></i>
                  <span class="fw-semibold">{{ $class->rating }}</span>
                  <span class="text-muted ms-2">Peringkat Tutor</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-award me-2"></i>
                  <span class="text-muted">{{ $class->reviews_count ?? '1,234' }} Ulasan</span>
                </div>
                <div class="d-flex align-items-center">
                  <i class="bi bi-people me-2"></i>
                  <span class="text-muted">{{ number_format($class->students_count ?? 12000) }} Peserta</span>
                </div>
              </div>
              
              <p class="mb-0" style="line-height: 1.6;">
                {{ $class->instructor_bio ?? 'Instruktur berpengalaman dengan dedikasi tinggi untuk memberikan pendidikan berkualitas. Memiliki keahlian mendalam di bidangnya dan telah membantu ribuan peserta mencapai tujuan pembelajaran mereka.' }}
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>

    {{-- Right Column - Sidebar --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-lg sticky-top" style="top: 100px;">
        @if($class->price > 0)
          {{-- Video Preview --}}
          @if($class->preview_url)
          <div class="ratio ratio-16x9 card-img-top">
            @if(Str::contains($class->preview_url, 'youtube.com') || Str::contains($class->preview_url, 'vimeo.com'))
              <iframe src="{{ $class->preview_url }}" title="Course Preview" allowfullscreen class="rounded-top"></iframe>
            @else
              <video controls poster="{{ $class->thumbnail }}" class="rounded-top">
                <source src="{{ asset('storage/videos/' . $class->preview_url) }}" type="video/mp4">
                Browser kamu tidak mendukung video tag.
              </video>
            @endif
          </div>
          @endif

          <div class="card-body p-4">
            {{-- Harga --}}
            <h3 class="fw-bold mb-3" style="color:#e74c3c;">
              Rp{{ number_format($class->price) }}
              @if($class->original_price > $class->price)
                <small class="text-muted text-decoration-line-through fs-6 ms-2">
                  Rp{{ number_format($class->original_price) }}
                </small>
              @endif
            </h3>

            @if($class->discount)
              <div class="alert alert-success py-2 mb-3">
                <i class="bi bi-lightning-fill me-1"></i>
                <strong>Diskon {{ $class->discount }}%!</strong> Penawaran terbatas
              </div>
            @endif

            {{-- Enrollment Logic --}}
            @php
                $isEnrolled = false;
                $hasValidPayment = false;
                
                if (session('user_id')) {
                    $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                  ->where('class_id', $class->id)
                                  ->where('type', 'class')
                                  ->where('status', 'active')
                                  ->exists();

                    $hasValidPayment = \App\Models\Payment::where('user_id', session('user_id'))
                                       ->where('class_id', $class->id)
                                       ->where('status', 'settlement')
                                       ->exists();
                }
            @endphp

            @if($isEnrolled && $hasValidPayment)
                <a href="{{ route('elearning.class', $class->id) }}" class="btn btn-success btn-lg w-100 fw-bold mb-3 py-3">
                    <i class="bi bi-play-circle me-2"></i>Mulai Belajar
                </a>
            @elseif($hasValidPayment && !$isEnrolled)
                <div class="alert alert-info text-center mb-3">
                    <i class="bi bi-clock me-2"></i>
                    <small>Enrollment sedang diproses. Silakan tunggu beberapa saat.</small>
                </div>
                <a href="{{ route('checkout', $class->id) }}" class="btn btn-primary btn-lg w-100 fw-bold mb-3 py-3">
                    <i class="bi bi-credit-card me-2"></i>Beli Sekarang
                </a>
            @else
                <a href="{{ route('checkout', $class->id) }}" class="btn btn-primary btn-lg w-100 fw-bold mb-3 py-3">
                    <i class="bi bi-credit-card me-2"></i>Beli Sekarang
                </a>
            @endif

            <div class="text-center mb-3">
              <small class="text-muted">Jaminan uang kembali 30 hari</small>
            </div>

            <hr>

            {{-- Course Features --}}
            <h6 class="fw-bold mb-3" style="color:#2c3e50;">Kursus ini mencakup:</h6>
            <div class="course-features">
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-camera-video text-primary me-3 fs-5"></i>
                <span>{{ $class->duration }} jam video on-demand</span>
              </div>
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-file-text text-primary me-3 fs-5"></i>
                <span>{{ $class->lessons_count ?? '25' }} artikel</span>
              </div>
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-phone text-primary me-3 fs-5"></i>
                <span>Akses di perangkat seluler dan TV</span>
              </div>
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-infinity text-primary me-3 fs-5"></i>
                <span>Akses penuh seumur hidup</span>
              </div>
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-award text-primary me-3 fs-5"></i>
                <span>Sertifikat penyelesaian</span>
              </div>
              <div class="d-flex align-items-center mb-0">
                <i class="bi bi-arrow-clockwise text-primary me-3 fs-5"></i>
                <span>Jaminan uang kembali 30 hari</span>
              </div>
            </div>
          </div>
        @else
          {{-- Free Course --}}
          <div class="card-body text-center p-4">
            <h3 class="fw-bold text-success mb-3">GRATIS</h3>
            <a href="{{ route('elearning.class', $class->id) }}" class="btn btn-success btn-lg w-100 fw-bold mb-3">
              Mulai Belajar Sekarang
            </a>
            <p class="text-muted small mb-0">Tidak ada biaya tersembunyi</p>
          </div>
        @endif
      </div>

      {{-- Share Course --}}
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4 text-center">
          <h6 class="fw-bold mb-3">Bagikan kursus ini</h6>
          <div class="d-flex justify-content-center gap-2">
            <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i></a>
            <a href="#" class="btn btn-outline-info btn-sm"><i class="bi bi-twitter"></i></a>
            <a href="#" class="btn btn-outline-success btn-sm"><i class="bi bi-whatsapp"></i></a>
            <a href="#" class="btn btn-outline-dark btn-sm"><i class="bi bi-link-45deg"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection