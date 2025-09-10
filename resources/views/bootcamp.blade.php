@extends('layouts.app')
@section('title', 'Bootcamp & Program')

{{-- CSS --}}
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    :root {
        --primary-gold: #ecac57;
        --primary-brown: #944e25;
        --light-cream: #f3efec;
        --deep-brown: #6b3419;
        --soft-gold: #f4d084;
        --text-primary: #2c2c2c;
        --text-secondary: #666666;
        --background-light: #fefefe;
        --background-section: #f8f8f8;
        --success-green: #4a7c59;
        --info-blue: #5b7c8a;
        --alert-orange: #d97435;
        --border-light: #e5e5e5;
        --shadow-light: 0 2px 12px rgba(107, 52, 25, 0.08);
        --shadow-medium: 0 4px 20px rgba(107, 52, 25, 0.12);
        --shadow-hover: 0 8px 32px rgba(107, 52, 25, 0.15);
    }
    body {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        line-height: 1.6;
        color: var(--text-primary);
        background-color: var(--background-light);
    }
    .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

/* ✅ Hero full width */
.hero { 
    background: linear-gradient(135deg, var(--light-cream) 0%, #f9f6f3 100%); 
    padding: 80px 0; 
    margin-bottom: 80px; 
    width: 100%;
}

.hero-content { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 60px; 
    align-items: center; 
}

.hero-text h1 { 
    font-size: clamp(32px, 4vw, 48px); 
    font-weight: 700; 
    margin-bottom: 24px; 
}

.hero-text p { 
    font-size: 1.2rem; 
    margin-bottom: 30px; 
    color: #555; 
}

.hero-buttons { 
    display: flex; 
    gap: 16px; 
    flex-wrap: wrap; 
}

.hero-img img { 
    width: 100%; 
    max-width: 500px; 
    border-radius: 20px; 
    box-shadow: var(--shadow-medium); 
}

/* Section & Card Styles */
.section { margin-bottom: 80px; }
.section-header { text-align: center; margin-bottom: 48px; }

.program-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
    gap: 32px; 
}

.program-card { 
    background: var(--background-light); 
    border-radius: 20px; 
    padding: 24px; 
    box-shadow: var(--shadow-light); 
    border: 1px solid var(--border-light); 
    transition: all 0.3s ease; 
    position: relative; 
    overflow: hidden; 
}

.program-card::before { 
    content: ''; 
    position: absolute; 
    top: 0; 
    left: 0; 
    right: 0; 
    height: 4px; 
    background: linear-gradient(90deg, var(--primary-gold), var(--primary-brown)); 
}

.program-card:hover { 
    transform: translateY(-8px); 
    box-shadow: var(--shadow-hover); 
}

.program-card img { 
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
    border-radius: 16px; 
    margin-bottom: 20px; 
}

.program-footer { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-top: auto; 
    padding-top: 20px; 
    border-top: 1px solid var(--border-light); 
}

/* Corporate Section */
.corporate-section { 
    background: var(--background-section); 
    padding: 80px 0; 
    border-radius: 32px; 
    text-align: center; 
    margin: 80px 0; 
}

.partners-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); 
    gap: 32px; 
    margin: 40px 0; 
}

.partner-logo { 
    height: 60px; 
    background: var(--background-light); 
    border-radius: 12px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-weight: 600; 
    color: var(--text-secondary); 
    box-shadow: var(--shadow-light); 
    transition: all 0.3s ease; 
}

.partner-logo:hover { 
    transform: translateY(-4px); 
    box-shadow: var(--shadow-medium); 
}


    /* ✅ Tombol */
    .btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 12px; font-weight: 600; text-decoration: none; font-size: 15px; transition: all 0.3s ease; border: none !important; cursor: pointer; }
    .btn-primary { background: var(--primary-gold) !important; color: var(--primary-brown) !important; }
    .btn-primary:hover { background: #d89a45 !important; color: var(--primary-brown) !important; transform: translateY(-2px); box-shadow: var(--shadow-medium); }
    .btn-secondary { background: var(--primary-brown) !important; color: #fff !important; }
    .btn-secondary:hover { background: var(--deep-brown) !important; color: #fff !important; transform: translateY(-2px); box-shadow: var(--shadow-medium); }

    .stats-section { background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%); padding: 60px 0; margin: 80px 0; border-radius: 24px; color: white; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center; }

    @media (max-width: 768px) { 
        .hero-content { grid-template-columns: 1fr; text-align: center; } 
        .program-grid { grid-template-columns: 1fr; } 
        .stats-grid { grid-template-columns: repeat(2, 1fr); } 
    }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }
</style>
@endsection



@section('content')
    <!-- Hero Section (FULL WIDTH) -->
    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Bootcamp yang Memberi Hasil. Fokus Praktik & Portfolio.</h1>
                <p>Full Online dan Dipandu oleh Praktisi Senior. Fokus bantu kembangkan skill dan portfolio ribuan alumni.</p>
                <div class="hero-buttons">
                    <a href="#programs" class="btn btn-primary"><i class="fas fa-target"></i> Lihat Program</a>
                    <a href="#promo" class="btn btn-secondary"><i class="fas fa-gift"></i> Dapatkan Promo</a>
                </div>
            </div>
            <div class="hero-img">
                <img src="{{ asset('assets/Bootcamp.jpg') }}" alt="Professional Learning Environment">
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item"><h3>5000+</h3><p>Alumni Tersertifikasi</p></div>
                <div class="stat-item"><h3>95%</h3><p>Tingkat Kepuasan</p></div>
                <div class="stat-item"><h3>50+</h3><p>Program Tersedia</p></div>
                <div class="stat-item"><h3>24/7</h3><p>Dukungan Mentor</p></div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="section" id="programs">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-rocket"></i> Program Bootcamp & Kelas</h2>
                <p class="section-subtitle">Pilih program yang sesuai dengan kebutuhan karir Anda.</p>
            </div>
            <div class="program-grid">
                <div class="program-card">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=200&fit=crop&crop=center" alt="Digital Marketing">
                    <h3>Digital Marketing Mastery</h3>
                    <p>Pelajari strategi digital marketing terkini termasuk SEO, SEM, Social Media Marketing, dan Analytics.</p>
                    <div class="program-footer">
                        <span class="program-date"><i class="fas fa-calendar"></i> Mulai: 15 Sep 2025</span>
                        <a href="{{ route('deskripsi_kelas') }}" class="btn btn-primary btn-small">Daftar</a>
                    </div>
                </div>
                <div class="program-card">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=200&fit=crop&crop=center" alt="Digital Marketing">
                    <h3>Digital Marketing Mastery</h3>
                    <p>Pelajari strategi digital marketing terkini termasuk SEO, SEM, Social Media Marketing, dan Analytics.</p>
                    <div class="program-footer">
                        <span class="program-date"><i class="fas fa-calendar"></i> Mulai: 15 Sep 2025</span>
                        <a href="{{ route('deskripsi_kelas') }}" class="btn btn-primary btn-small">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Corporate Section -->
    <section class="corporate-section">
        <div class="container corporate-content">
            <h2><i class="fas fa-building"></i> E-learning & Training Untuk Perusahaan</h2>
            <p>Miliki akses ratusan konten e-learning LearnServe serta dukungan corporate training untuk perusahaan.</p>
            <div class="partners-grid">
                <div class="partner-logo">Microsoft</div>
                <div class="partner-logo">Bank Mandiri</div>
                <div class="partner-logo">Bank Indonesia</div>
                <div class="partner-logo">Mizan Group</div>
                <div class="partner-logo">Tokopedia</div>
                <div class="partner-logo">Gojek</div>
            </div>
            <a href="#" class="btn btn-primary"><i class="fas fa-phone"></i> Hubungi Tim LearnServe</a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Scroll animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.program-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endsection
