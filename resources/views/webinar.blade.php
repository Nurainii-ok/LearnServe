@extends('layouts.app')
@section('title', 'Webinar')

<section class="hero-webinar py-5 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <!-- Konten Kiri -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <span class="badge bg-primary mb-3">🎤 Live Webinar</span>
        <h1 class="fw-bold mb-3">Webinar: Rahasia Sukses Karier di Era Digital</h1>
        <p class="lead text-muted mb-4">
          Ikuti webinar eksklusif dengan pakar industri untuk mempelajari
          strategi membangun karier digital yang sukses. Gratis untuk 500 peserta pertama!
        </p>
        <ul class="list-unstyled mb-4">
          <li>📅 Tanggal: 25 September 2025</li>
          <li>🕒 Waktu: 19.00 - 21.00 WIB</li>
          <li>👤 Pemateri: <strong>Rizki Putra, Digital Marketing Expert</strong></li>
        </ul>
        <a href="#daftar" class="btn btn-primary btn-lg me-3">Daftar Sekarang</a>
        <a href="#detail" class="btn btn-outline-secondary btn-lg">Lihat Detail</a>
      </div>

      <!-- Konten Kanan -->
      <div class="col-lg-6 text-center">
        <img src="{{ asset('assets/images/webinar-hero.png') }}" 
             alt="Webinar" 
             class="img-fluid rounded shadow">
      </div>
    </div>
  </div>
</section>
