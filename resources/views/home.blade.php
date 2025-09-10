@extends('layouts.app')
@section('title', 'Bootcamp & Program')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - LearnServe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fefefe;
            color: #2c2c2c;
            line-height: 1.6;
        }

        /* Clean Color Palette */
        :root {
            --primary-gold: #ecac57;
            --primary-brown: #944e25;
            --light-cream: #f3efec;
            --deep-brown: #6b3419;
            --soft-gold: #f4d084;
            --text-primary: #2c2c2c;
            --text-secondary: #666666;
            --bg-light: #fefefe;
            --bg-section: #f8f8f8;
            --success-green: #4a7c59;
            --info-blue: #5b7c8a;
            --alert-orange: #d97435;
            --border-light: #e8e8e8;
        }

        /* Clean Typography */
        .section-title {
            font-size: 2.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            font-weight: 400;
        }

        /* Clean Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--light-cream) 0%, #ffffff 100%);
            border-radius: 20px;
            padding: 80px 60px;
            margin: 40px 0;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-gold), var(--soft-gold));
            opacity: 0.1;
            border-radius: 0 20px 20px 0;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 3.5rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .hero .highlight {
            color: var(--primary-gold);
        }

        /* Clean Buttons */
        .btn-primary-custom {
            background: var(--primary-gold);
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.125rem;
            transition: all 0.3s ease;
            color: white;
            box-shadow: 0 4px 12px rgba(236, 172, 87, 0.3);
        }

        .btn-primary-custom:hover {
            background: var(--primary-brown);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(236, 172, 87, 0.4);
        }

        /* Clean Section Badge */
        .section-badge {
            background: var(--light-cream);
            color: var(--primary-brown);
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
            border: 1px solid var(--primary-gold);
        }

        /* Clean Category Cards */
        .category-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            transition: all 0.4s ease;
            cursor: pointer;
            border: 1px solid var(--border-light);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-gold), var(--soft-gold));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .category-card:hover::before {
            transform: scaleX(1);
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-gold);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 28px;
            background: var(--light-cream);
            color: var(--primary-brown);
        }

        .category-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .category-desc {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Clean Course Cards */
        .popular-course {
            display: flex;                  /* jadikan flex container */
            flex-direction: column;         /* isi disusun vertikal */
            justify-content: space-between; /* isi atas-bawah merata */
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            cursor: pointer;
            border: 1px solid var(--border-light);
            position: relative;
            height: 100%;                   /* ✅ sama tinggi dengan card lain */
        }

        .popular-course:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .course-image {
            height: 220px; /* ✅ tinggi seragam */
            background: linear-gradient(135deg, var(--primary-gold), var(--soft-gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            flex-shrink: 0; /* jangan mengecil */
        }

        .course-content {
            flex: 1;                /* ✅ isi menyesuaikan */
            display: flex;
            flex-direction: column; /* konten tersusun vertikal */
            padding: 28px;
        }

        .course-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .course-desc {
            color: var(--text-secondary);
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.6;
            flex-grow: 1; /* ✅ isi deskripsi bisa mengisi ruang kosong */
        }

        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid var(--border-light);
            margin-top: auto; /* dorong ke bawah */
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--primary-gold);
            font-weight: 500;
        }

        .course-price {
            font-weight: 600;
            color: var(--primary-brown);
            font-size: 1.125rem;
        }

        /* Clean Why Section */
        .why-section {
            background: var(--bg-section);
            padding: 80px 0;
            margin: 80px 0;
        }

        .card-custom {
            background: white;
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid var(--border-light);
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .card-custom img {
            margin-bottom: 24px;
            filter: hue-rotate(20deg) saturate(0.8);
        }

        .card-custom h5 {
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--text-primary);
            font-size: 1.25rem;
        }

        .card-custom p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Clean Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 4rem;
            color: var(--light-cream);
            font-family: Georgia, serif;
            z-index: 1;
        }

        .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .testimonial-text {
            font-size: 1.125rem;
            color: var(--text-secondary);
            font-style: italic;
            margin-bottom: 32px;
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }

        .author-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-gold), var(--soft-gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0 auto 16px;
        }

        .author-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
            font-size: 1.125rem;
        }

        .author-role {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Clean Spacing */
        .section-spacing {
            margin: 100px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                padding: 60px 40px;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .category-card, .card-custom, .testimonial-card {
                margin-bottom: 24px;
            }
        }

        /* Clean animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            animation: fadeInUp 0.8s ease forwards;
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4">
        <!-- Clean Hero Section -->
        <section class="hero row align-items-center">
            <div class="col-lg-6">
                <h1>Belajar dan Berkembang Bersama <br><span class="highlight">LearnServe</span></h1>
                <p>Platform pembelajaran online dengan bootcamp dan e-learning terbaik untuk meningkatkan skill digitalmu dan mewujudkan karir impianmu.</p>
                <a href="#" class="btn btn-primary-custom">Mulai Perjalananmu</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('assets/Bootcamp2.jpg') }}" 
                    alt="Bootcamp Illustration" 
                    style="width: 100%; height: 400px; object-fit: cover; border-radius: 20px;">
            </div>

        </section>

        <!-- Clean Categories Section -->
        <section class="section-spacing">
            <div class="text-center">
                <span class="section-badge">⭐ Kategori Terpopuler</span>
                <h2 class="section-title">Jelajahi Kursus</h2>
                <p class="section-subtitle">Kembangkan skill yang paling dibutuhkan industri dan raih karir impianmu</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">💻</div>
                        <div class="category-title">Software Development</div>
                        <div class="category-desc">Pelajari bahasa pemrograman modern dan framework terbaru untuk membangun aplikasi canggih</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">📱</div>
                        <div class="category-title">Digital Marketing</div>
                        <div class="category-desc">Kuasai strategi pemasaran digital dan tools terbaru untuk mengembangkan bisnis</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">📊</div>
                        <div class="category-title">Business Intelligence</div>
                        <div class="category-desc">Analisis data untuk membuat keputusan bisnis yang tepat dan strategis</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">🚀</div>
                        <div class="category-title">Freelancing Journey</div>
                        <div class="category-desc">Bangun karir freelance yang sukses dan mandiri dari nol hingga profesional</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">📈</div>
                        <div class="category-title">Data Analytics</div>
                        <div class="category-desc">Pahami perilaku pelanggan melalui analisis data yang mendalam</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">🎨</div>
                        <div class="category-title">UX Design</div>
                        <div class="category-desc">Ciptakan pengalaman pengguna yang menarik dan konten yang engaging</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">🔍</div>
                        <div class="category-title">Quality Assurance</div>
                        <div class="category-desc">Pastikan kualitas software melalui testing yang comprehensive</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">💼</div>
                        <div class="category-title">Business Skills</div>
                        <div class="category-desc">Kembangkan kemampuan bisnis dan kepemimpinan yang esensial</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clean Popular Courses Section -->
        <section class="section-spacing">
            <div class="row align-items-center mb-5">
                <div class="col">
                    <h2 class="section-title mb-2">Kelas Populer</h2>
                    <p class="section-subtitle mb-0">Kelas terpopuler yang banyak diminati dan terbukti mengantarkan siswa meraih kesuksesan</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('learning') }}" style="color: var(--primary-brown); font-weight: 600; text-decoration: none; font-size: 1.1rem;">Lihat Semua →</a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="popular-course">
                        <div class="course-image">🌐</div>
                        <div class="course-content">
                            <div class="course-title">Full Stack Web Development</div>
                            <div class="course-desc">Belajar membuat website modern dengan teknologi terbaru dari frontend hingga backend secara komprehensif</div>
                            <div class="course-meta">
                                <div class="course-rating">
                                    <span>⭐</span>
                                    <span>4.8 (2.1k)</span>
                                </div>
                                <div class="course-price">Rp 299.000</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="popular-course">
                        <div class="course-image">🎨</div>
                        <div class="course-content">
                            <div class="course-title">UI/UX Design Mastery</div>
                            <div class="course-desc">Membuat desain aplikasi yang menarik dan user-friendly dengan tools professional terkini</div>
                            <div class="course-meta">
                                <div class="course-rating">
                                    <span>⭐</span>
                                    <span>4.9 (1.8k)</span>
                                </div>
                                <div class="course-price">Rp 399.000</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="popular-course">
                        <div class="course-image">📱</div>
                        <div class="course-content">
                            <div class="course-title">Digital Marketing Pro</div>
                            <div class="course-desc">Optimasi bisnis melalui internet dengan strategi marketing digital yang efektif dan terukur</div>
                            <div class="course-meta">
                                <div class="course-rating">
                                    <span>⭐</span>
                                    <span>4.7 (1.5k)</span>
                                </div>
                                <div class="course-price">Rp 249.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clean Why Choose Section -->
        <section class="why-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Kenapa Memilih LearnServe?</h2>
                    <p class="section-subtitle">Bergabunglah dengan ribuan siswa yang telah merasakan pengalaman belajar terbaik</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card-custom">
                            <img src="https://img.icons8.com/color/96/learning.png" alt="Materi Lengkap">
                            <h5>Materi Terlengkap</h5>
                            <p>Kurikulum yang selalu update sesuai kebutuhan industri terkini dengan materi yang komprehensif dan praktis</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-custom">
                            <img src="https://img.icons8.com/color/96/training.png" alt="Mentor Berpengalaman">
                            <h5>Mentor Ahli</h5>
                            <p>Dibimbing langsung oleh para praktisi profesional dengan pengalaman bertahun-tahun di industri</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-custom">
                            <img src="https://img.icons8.com/color/96/certificate.png" alt="Sertifikat Resmi">
                            <h5>Sertifikat Berstandar</h5>
                            <p>Raih sertifikat yang diakui industri untuk meningkatkan portofolio dan peluang karir yang cemerlang</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clean Testimonials Section -->
        <section class="section-spacing">
            <div class="text-center mb-5">
                <h2 class="section-title">Testimoni Siswa</h2>
                <p class="section-subtitle">Dengarkan cerita sukses mereka yang telah bergabung bersama LearnServe</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            Platform ini benar-benar mengubah hidup saya. Materinya sangat lengkap dan mudah dipahami. Sekarang saya sudah bekerja sebagai Full Stack Developer di startup unicorn!
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">A</div>
                            <div class="author-name">Andi Pratama</div>
                            <div class="author-role">Full Stack Developer</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            Instrukturnya sangat berpengalaman dan sabar dalam mengajar. Saya yang awalnya tidak tahu apa-apa tentang design, sekarang bisa freelance UI/UX dengan income yang stabil.
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">S</div>
                            <div class="author-name">Siti Nurhaliza</div>
                            <div class="author-role">UI/UX Designer</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            Bootcamp digital marketing di LearnServe sangat worth it! Bisnis online saya sekarang berkembang pesat dan omzet naik 300% berkat ilmu yang saya dapat.
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">B</div>
                            <div class="author-name">Budi Santoso</div>
                            <div class="author-role">Digital Entrepreneur</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll animation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-on-scroll');
                    }
                });
            }, observerOptions);

            // Observe all cards
            document.querySelectorAll('.category-card, .popular-course, .testimonial-card, .card-custom').forEach(card => {
                observer.observe(card);
            });

            // Add subtle click feedback
            document.querySelectorAll('.category-card, .popular-course').forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>
