@extends('layouts.app')

@section('title', 'Detail Kursus')

@section('content')
<div class="container my-5">

  <style>
    .card .btn-primary {
      background-color: #5624d0 !important;
      border-color: #5624d0 !important;
    }
    .card .btn-primary:hover {
      background-color: #471aa0 !important;
    }
  </style>

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

      <!-- Persyaratan -->
      <div class="mb-4">
        <h5 class="fw-bold mb-3">Persyaratan</h5>
        <p>Kursus ini dirancang untuk Anda yang ingin menjadi Full Stack Developer. Mulai dari membuat tampilan web (frontend), membangun server (backend), mengatur database, hingga melakukan deployment ke server. Semua dijelaskan dengan praktik nyata agar siap menghadapi industri.</p>
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
          <img src="{{ asset('assets/L1.jpg') }}" alt="Instruktur" class="rounded-circle me-3" style="width:60px; height:60px; object-fit:cover;">
          <div>
            <h6 class="mb-0">Ahmad Rizki</h6>
            <small class="text-muted">Senior Full Stack Developer</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar Kanan -->
<!-- Sidebar Kanan -->
<div class="col-lg-4">
  <div class="card shadow-sm border-0 sticky-top" style="top: 100px; background-color:#f3efec;">
    <div class="card-body">

      <!-- Harga -->
      <h3 class="fw-bold" style="color:#944e25;">
        Rp139.000 
        <small class="text-muted text-decoration-line-through fs-6">Rp169.000</small>
      </h3>
      <p style="color:#944e25; font-weight:600;">Diskon 18%</p>
      <!--<p style="color:#d9534f;"><i class="bi bi-alarm"></i> 14 jam lagi dengan harga ini!</p>-->

      <!-- Tombol -->

      <!--<button class="btn w-100 fw-bold mb-2" 
              style="background-color:#944e25; color:white; border:none;">
        Tambahkan ke Keranjang
      </button>-->
      <a href="{{ route('checkout') }}" 
         class="btn w-100 fw-bold mb-3" 
         style="background-color:#944e25; color:white; border:none;">
          <i class="fas fa-credit-card me-2"></i>Beli Sekarang
      </a>


      <!--<p class="text-center small" style="color:#944e25;">Jaminan Uang Kembali 30 Hari</p>-->
      <hr>

      <!-- Fitur -->
      <h6 class="fw-bold mb-3" style="color:#944e25;">Kursus ini mencakup:</h6>
      <ul class="list-unstyled small mb-4" style="color:#333;">
        <li>📺 43 jam video on-demand</li>
        <!--<li>📄 10 artikel</li>-->
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

    </div>
  </div>
</div>

  </div>

</div>
@endsection
