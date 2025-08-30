@extends('layouts.app')
@section('title', 'Bootcamp & Program')

@section('content')
<div class="container">

    {{-- Hero Section --}}
    <section class="hero">
        <div class="hero-text">
            <h1>Bootcamp yang Memberi Hasil. Fokus Praktik & Portfolio.</h1>
            <p>
                Full Online dan Dipandu oleh Praktisi Senior. Fokus bantu kembangkan skill dan portfolio ribuan alumni.
            </p>
            <div class="hero-buttons">
                <a href="#" class="btn btn-yellow">🎯 Lihat Program</a>
                <a href="#" class="btn btn-blue">💡 Dapatkan Promo</a>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/Bootcamp.jpg') }}" alt="Hero Image">
        </div>
    </section>

    {{-- Daftar Bootcamp --}}
    <section class="section">
        <h2 class="section-title">🚀 Program Bootcamp & Kelas</h2>
        <div class="grid">
            @for ($i = 1; $i <= 12; $i++)
                <div class="card">
                    <img src="{{ asset('assets/Digital Marketing.png') }}" alt="Program {{ $i }}">
                    <h3>Bootcamp {{ $i }}</h3>
                    <p>Deskripsi singkat program bootcamp LearnServe ke-{{ $i }}.</p>
                    <div class="card-footer">
                        <span>Mulai: 15 Sep 2025</span>
                        <a href="#" class="btn btn-blue small">Daftar</a>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    {{-- Training untuk Perusahaan --}}
    <section class="corporate">
        <h2>🏢 E-learning & Training Untuk Perusahaan</h2>
        <p>
            Miliki akses ratusan konten e-learning LearnServe serta dukungan corporate training untuk perusahaan.
        </p>
        <div class="partners">
            <img src="https://via.placeholder.com/120x50" alt="Microsoft">
            <img src="https://via.placeholder.com/120x50" alt="Mandiri">
            <img src="https://via.placeholder.com/120x50" alt="BI">
            <img src="https://via.placeholder.com/120x50" alt="Mizan">
        </div>
        <a href="#" class="btn btn-yellow">Hubungi Tim MySkill</a>
    </section>

</div>
@endsection

<style>
/* Container */
.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 30px 20px;
    font-family: 'Segoe UI', sans-serif;
}

/* Hero Section */
.hero {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #f0f8ff, #e0f2ff);
    border-radius: 24px;
    padding: 50px;
    margin-bottom: 60px;
    gap: 20px;
}
.hero-text {
    flex: 1;
    min-width: 300px;
}
.hero-text h1 {
    font-size: 34px;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 20px;
}
.hero-text p {
    color: #444;
    font-size: 16px;
    margin-bottom: 25px;
}
.hero-buttons {
    display: flex;
    gap: 15px;
}
.hero-img {
    flex: 1;
    text-align: center;
}
.hero-img img {
    max-width: 420px;
    border-radius: 18px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}

/* Section */
.section {
    margin-bottom: 70px;
}
.section-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 25px;
    text-align: center;
}

/* Grid */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

/* Card */
.card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
.card img {
    width: 100%;
    border-radius: 12px;
    margin-bottom: 15px;
}
.card h3 {
    font-size: 19px;
    font-weight: 600;
    margin: 10px 0;
}
.card p {
    font-size: 15px;
    color: #555;
    flex-grow: 1;
}
.card-footer {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #666;
}

/* Corporate Section */
.corporate {
    text-align: center;
    background: #f9fafb;
    padding: 60px 40px;
    border-radius: 24px;
}
.corporate h2 {
    font-size: 26px;
    margin-bottom: 20px;
    font-weight: 700;
}
.corporate p {
    max-width: 650px;
    margin: 0 auto 25px;
    color: #444;
    font-size: 16px;
}
.partners {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    margin-bottom: 30px;
}
.partners img {
    max-height: 45px;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}
.partners img:hover {
    opacity: 1;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    font-size: 15px;
    transition: all 0.2s ease;
}
.btn-yellow {
    background: #FFD93D;
    color: #111;
}
.btn-blue {
    background: #2563EB;
    color: #fff;
}
.btn.small {
    padding: 7px 14px;
    font-size: 14px;
}
.btn.full {
    margin-top: auto;
}
.btn:hover {
    opacity: 0.9;
}
</style>
