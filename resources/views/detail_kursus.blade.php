@extends('layouts.app') 
@section('title', 'Detail Kursus')

@section('content')
<div class="container my-5">

  <div class="row">
    <!-- Konten Kiri -->
    <div class="col-lg-8">
      <!-- Judul & Info Kursus -->
      <h1 class="fw-bold mb-3">Full Stack Web Development</h1>
      <p class="lead text-muted">Belajar membuat website modern dengan teknologi terbaru dari frontend hingga backend secara komprehensif.</p>

      <div class="d-flex align-items-center mb-3">
        <span class="badge bg-warning text-dark me-2">Best Seller</span>
        <span>⭐ 4.9 (8.752 rating) • 35.000 peserta</span>
      </div>
      <!--<p>Dibuat oleh <a href="#">Tim Developer Expert</a></p>-->
      <p><i class="bi bi-globe"></i> Bahasa Indonesia • <i class="bi bi-clock-history"></i> Update terakhir 09/2025</p>

      <!-- Apa yang akan dipelajari -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Yang akan Anda pelajari</h5>
          <div class="row">
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li>✔️ HTML, CSS, dan JavaScript dasar</li>
                <li>✔️ Framework Frontend (React / Vue)</li>
                <li>✔️ Desain responsif & UI/UX dasar</li>
                <li>✔️ Git & version control</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li>✔️ Backend dengan Node.js & Express</li>
                <li>✔️ Database MySQL & MongoDB</li>
                <li>✔️ Autentikasi & keamanan</li>
                <li>✔️ Deployment ke server/cloud</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Konten Kursus -->
      <div class="mb-4">
        <h5 class="fw-bold mb-3">Konten Kursus</h5>
        <div class="accordion" id="courseContent">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                Dasar Pemrograman Web
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#courseContent">
              <div class="accordion-body">
                <ul class="list-unstyled mb-0">
                  <li>📺 Pengenalan Web Development (05:00)</li>
                  <li>📺 HTML & Struktur Halaman (12:00)</li>
                  <li>📺 CSS Dasar & Layouting (15:00)</li>
                  <li>📺 JavaScript Dasar (20:00)</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                Frontend Development
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#courseContent">
              <div class="accordion-body">
                <ul class="list-unstyled mb-0">
                  <li>📺 JavaScript Lanjutan (18:00)</li>
                  <li>📺 React Components & Hooks (25:00)</li>
                  <li>📺 State Management (15:00)</li>
                  <li>📺 Integrasi API ke Frontend (20:00)</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                Backend Development
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#courseContent">
              <div class="accordion-body">
                <ul class="list-unstyled mb-0">
                  <li>📺 Node.js & Express (20:00)</li>
                  <li>📺 REST API (18:00)</li>
                  <li>📺 Database MySQL & MongoDB (25:00)</li>
                  <li>📺 Autentikasi & Middleware (22:00)</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                Deployment & Studi Kasus
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#courseContent">
              <div class="accordion-body">
                <ul class="list-unstyled mb-0">
                  <li>📺 GitHub & GitHub Actions (15:00)</li>
                  <li>📺 Deployment ke Vercel/Netlify (12:00)</li>
                  <li>📺 Deployment Backend ke VPS/Cloud (20:00)</li>
                  <li>📺 Studi Kasus: Membuat Aplikasi Full Stack (30:00)</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <h5 class="fw-bold mb-3">Deskripsi</h5>
        <p>Kursus ini dirancang untuk Anda yang ingin menjadi Full Stack Developer. Mulai dari membuat tampilan web (frontend), membangun server (backend), mengatur database, hingga melakukan deployment ke server. Semua dijelaskan dengan praktik nyata agar siap menghadapi industri.</p>
      </div>

      <!-- Instruktor -->
      <div class="mb-4">
        <h5 class="fw-bold mb-3">Instruktur</h5>
        <div class="d-flex align-items-center">
          <img src="{{ asset('assets/instructors/mentor2.jpg') }}" alt="Instruktur" class="rounded-circle me-3" style="width:60px; height:60px; object-fit:cover;">
          <div>
            <h6 class="mb-0">Ahmad Rizki</h6>
            <small class="text-muted">Senior Full Stack Developer</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar Kanan -->
    <div class="col-lg-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/courses/webdev.jpg') }}" class="card-img-top" alt="Web Development Course">
        <div class="card-body">
          <h3 class="fw-bold mb-3">Rp299.000</h3>
          <button class="btn btn-primary w-100 mb-2">Tambah ke Keranjang</button>
          <button class="btn btn-success w-100">Beli Sekarang</button>
          <hr>
          <ul class="list-unstyled small">
            <li>⏱️ 30+ jam video on-demand</li>
            <li>📄 Artikel & resources</li>
            <li>📱 Akses di HP & TV</li>
            <li>🏆 Sertifikat penyelesaian</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
