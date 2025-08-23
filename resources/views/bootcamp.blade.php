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
                <a href="#" class="btn btn-yellow">Lihat Program Pilihan</a>
                <a href="#" class="btn btn-blue">Dapatkan Promo</a>
            </div>
        </div>
        <div class="hero-img">
            <img src="https://via.placeholder.com/400x250" alt="Hero Image">
        </div>
    </section>

    {{-- Testimoni Alumni --}}
    <section class="section">
        <h2>Testimoni Alumni Bootcamp MySkill</h2>
        <div class="grid">
            @for ($i = 1; $i <= 6; $i++)
                <div class="card">
                    <img src="{{ asset('assets/tuktuk.jpg') }}" alt="Testimoni {{ $i }}">
                    <h3>Alumni {{ $i }}</h3>
                    <p>Cerita singkat alumni tentang perjalanan belajar di bootcamp MySkill.</p>
                    <a href="#" class="btn btn-blue full">Baca Cerita</a>
                </div>
            @endfor
        </div>
    </section>

    {{-- Daftar Bootcamp --}}
    <section class="section">
        <h2>Program Bootcamp & Kelas</h2>
        <div class="grid">
            @for ($i = 1; $i <= 12; $i++)
                <div class="card">
                    <img src="{{ asset('assets/tuktuk.jpg') }}" alt="Program {{ $i }}">
                    <h3>Bootcamp {{ $i }}</h3>
                    <p>Deskripsi singkat program bootcamp MySkill ke-{{ $i }}.</p>
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
        <h2>E-learning & Training Untuk Perusahaan</h2>
        <p>
            Miliki akses ratusan konten e-learning MySkill serta dukungan corporate training untuk perusahaan.
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
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Hero Section */
.hero {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    background: #f0f8ff;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 40px;
}
.hero-text {
    flex: 1;
    min-width: 280px;
}
.hero-text h1 {
    font-size: 28px;
    margin-bottom: 15px;
}
.hero-text p {
    color: #555;
    margin-bottom: 20px;
}
.hero-buttons {
    display: flex;
    gap: 10px;
}
.hero-img {
    flex: 1;
    text-align: center;
}
.hero-img img {
    max-width: 100%;
    border-radius: 15px;
}

/* Section */
.section {
    margin-bottom: 50px;
}
.section h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

/* Grid */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

/* Card */
.card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 15px;
    display: flex;
    flex-direction: column;
}
.card img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 10px;
}
.card h3 {
    font-size: 18px;
    margin: 10px 0;
}
.card p {
    font-size: 14px;
    color: #555;
    flex-grow: 1;
}
.card-footer {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #777;
}

/* Corporate Section */
.corporate {
    text-align: center;
    background: #f8f8f8;
    padding: 40px;
    border-radius: 20px;
}
.corporate h2 {
    font-size: 24px;
    margin-bottom: 15px;
}
.corporate p {
    max-width: 600px;
    margin: 0 auto 20px;
    color: #555;
}
.partners {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}
.partners img {
    max-height: 40px;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
}
.btn-yellow {
    background: #FFD93D;
    color: #000;
}
.btn-blue {
    background: #2563EB;
    color: #fff;
}
.btn.small {
    padding: 6px 12px;
    font-size: 13px;
}
.btn.full {
    margin-top: auto;
}

</style>