@extends('layouts.app')
@section('title', 'Bootcamp & Program')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection


@section('content')

<div class="container-fluid px-4">
    <!-- Clean Hero Section -->
    <section class="hero row align-items-center">
        <div class="col-lg-6">
            <h1>Belajar dan Berkembang Bersama <br><span class="highlight">LearnServe</span></h1>
            <p>Platform pembelajaran online dengan bootcamp dan e-learning terbaik untuk meningkatkan skill digitalmu dan mewujudkan karir impianmu.</p>
            <!--<a href="#" class="btn btn-primary-custom">Mulai Perjalananmu</a>-->
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{ asset('assets/Bootcamp2.jpg') }}" 
                alt="Bootcamp Illustration" 
                style="width: 100%; height: 400px; object-fit: cover; border-radius: 20px;">
        </div>

    </section>

    <!-- Clean Categories Section -->
    <section class="section-spacing py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge">⭐ Kategori Terpopuler</span>
                <h2 class="section-title">Jelajahi Kursus</h2>
                <p class="section-subtitle">
                    Kembangkan skill yang paling dibutuhkan industri dan raih karir impianmu
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">💻</div>
                        <div class="category-title">Software Development</div>
                        <div class="category-desc">
                            Pelajari bahasa pemrograman modern dan framework terbaru untuk membangun aplikasi canggih
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">📱</div>
                        <div class="category-title">Digital Marketing</div>
                        <div class="category-desc">
                            Kuasai strategi pemasaran digital dan tools terbaru untuk mengembangkan bisnis
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">📊</div>
                        <div class="category-title">Business Intelligence</div>
                        <div class="category-desc">
                            Analisis data untuk membuat keputusan bisnis yang tepat dan strategis
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">🚀</div>
                        <div class="category-title">Freelancing Journey</div>
                        <div class="category-desc">
                            Bangun karir freelance yang sukses dan mandiri dari nol hingga profesional
                        </div>
                    </div>
                    </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">📈</div>
                        <div class="category-title">Data Analytics</div>
                        <div class="category-desc">
                            Pahami perilaku pelanggan melalui analisis data yang mendalam
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">🎨</div>
                        <div class="category-title">UX Design</div>
                        <div class="category-desc">
                            Ciptakan pengalaman pengguna yang menarik dan konten yang engaging
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">🔍</div>
                        <div class="category-title">Quality Assurance</div>
                        <div class="category-desc">
                            Pastikan kualitas software melalui testing yang comprehensive
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">💼</div>
                        <div class="category-title">Business Skills</div>
                        <div class="category-desc">
                            Kembangkan kemampuan bisnis dan kepemimpinan yang esensial
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Clean Popular Courses Section -->
    <section class="section-spacing py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col">
                    <h2 class="section-title mb-2">Kelas Populer</h2>
                    <!--<p class="section-subtitle mb-0">Kelas terpopuler yang banyak diminati dan terbukti mengantarkan siswa meraih kesuksesan</p>-->
                </div>
               <div class="col-auto">
                    <a href="{{ route('learning') }}" style="color: var(--primary-brown); font-weight: 600; text-decoration: none; font-size: 1.1rem;">Lihat Semua →</a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('detail_kursus', ['slug' => 'data-science-analytics']) }}" class="text-decoration-none text-dark">
                        <div class="popular-course">
                            <div class="course-image">
                                <img src="{{ asset('assets/Data Analytics.jpg') }}" alt="Data Science & Analytics">
                            </div>
                            <div class="course-content">
                                <div class="course-title">Data Science & Analytics</div>
                                <div class="course-desc">
                                    Optimasi bisnis melalui internet dengan strategi marketing digital yang efektif dan terukur
                                </div>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <span>⭐</span>
                                        <span>4.7 (1.5k)</span>
                                    </div>
                                    <div class="course-price">Rp 249.000</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('detail_kursus', ['slug' => 'web-development']) }}" class="text-decoration-none text-dark">
                        <div class="popular-course">
                            <div class="course-image">
                                <img src="{{ asset('assets/Full Stack.jpg') }}" alt="Web Development">
                            </div>
                            <div class="course-content">
                                <div class="course-title">Full Stack Web Development</div>
                                <div class="course-desc">
                                    Belajar membangun aplikasi web dari frontend sampai backend dengan teknologi modern
                                </div>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <span>⭐</span>
                                        <span>4.9 (2.1k)</span>
                                    </div>
                                    <div class="course-price">Rp 299.000</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('detail_kursus', ['slug' => 'digital-marketing']) }}" class="text-decoration-none text-dark">
                        <div class="popular-course">
                            <div class="course-image">
                                <img src="{{ asset('assets/Digital marketing.jpg') }}" alt="Digital Marketing">
                            </div>
                            <div class="course-content">
                                <div class="course-title">Digital Marketing</div>
                                    <div class="course-desc">
                                        Kuasai strategi digital marketing untuk bisnis online dan brand building
                                    </div>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <span>⭐</span>
                                        <span>4.7 (1.5k)</span>
                                    </div>
                                    <div class="course-price">Rp 249.000</div>
                                </div>
                            </div>
                        </div>
                    </a>
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
                        <!--<img src="https://img.icons8.com/color/96/learning.png" alt="Materi Lengkap">-->
                        <h5>Materi Terlengkap</h5>
                        <p>Kurikulum yang selalu update sesuai kebutuhan industri terkini dengan materi yang komprehensif dan praktis</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom">
                        <!--<img src="https://img.icons8.com/color/96/training.png" alt="Mentor Berpengalaman">-->
                        <h5>Mentor Ahli</h5>
                        <p>Dibimbing langsung oleh para praktisi profesional dengan pengalaman bertahun-tahun di industri</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom">
                        <!--<img src="https://img.icons8.com/color/96/certificate.png" alt="Sertifikat Resmi">-->
                        <h5>Sertifikat Berstandar</h5>
                        <p>Raih sertifikat yang diakui industri untuk meningkatkan portofolio dan peluang karir yang cemerlang</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clean Testimonials Section -->
    <!-- Testimonials Section -->
    <section class="section-spacing bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Testimoni</h2>
            </div>

            <div class="row g-4">
                <!-- Testimoni 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card p-4 h-100">
                        <p class="testimonial-text">
                            “Platform ini benar-benar mengubah hidup saya. Sekarang saya sudah bekerja sebagai <strong>Full Stack Developer</strong> di startup unicorn!”
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="{{ asset('assets/avatars/andi.jpg') }}" alt="Andi" class="author-avatar me-3">
                            <div>
                                <h6 class="author-name mb-0">Andi Pratama</h6>
                                <small class="author-role">Full Stack Developer</small>
                            </div>
                        </div>
                        <!--<a href="#" class="testimonial-link mt-3 d-inline-block">Lihat Kelas Web Development →</a>-->
                    </div>
                </div>

                <!-- Testimoni 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card p-4 h-100">
                        <p class="testimonial-text">
                            “Instrukturnya sabar dan jelas. Saya yang awalnya awam sekarang bisa <strong>freelance UI/UX</strong> dengan income stabil.”
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="{{ asset('assets/avatars/siti.jpg') }}" alt="Siti" class="author-avatar me-3">
                            <div>
                                <h6 class="author-name mb-0">Siti Nurhaliza</h6>
                                <small class="author-role">UI/UX Designer</small>
                            </div>
                        </div>
                        <!--<a href="#" class="testimonial-link mt-3 d-inline-block">Lihat Kelas UI/UX →</a>-->
                    </div>
                </div>

                <!-- Testimoni 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card p-4 h-100">
                        <p class="testimonial-text">
                            “Bootcamp Digital Marketing di LearnServe sangat worth it! Omzet bisnis saya naik <strong>300%</strong> berkat ilmunya.”
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="{{ asset('assets/avatars/budi.jpg') }}" alt="Budi" class="author-avatar me-3">
                            <div>
                                <h6 class="author-name mb-0">Budi Santoso</h6>
                                <small class="author-role">Digital Entrepreneur</small>
                            </div>
                        </div>
                        <!--<a href="#" class="testimonial-link mt-3 d-inline-block">Lihat Kelas Digital Marketing →</a>-->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <section class="section-spacing bg-light">
        <div class="container"><!-- ✅ Tambahin container di sini -->
            <div class="text-center mb-5">
                <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
                <p class="section-subtitle">Temukan jawaban dari pertanyaan umum tentang LearnServe</p>
            </div>

            <div class="accordion" id="faqAccordion">
                <!-- FAQ 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true">
                            Apa itu LearnServe?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            LearnServe adalah platform bootcamp dan pembelajaran online yang memudahkan Anda belajar dengan materi terstruktur, tugas interaktif, serta komunikasi langsung dengan tutor.
                        </div>
                    </div>
                </div>
                <!-- FAQ 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                Apakah saya harus membuat akun untuk bisa ikut kelas?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya. Anda bisa melihat daftar kelas tanpa login, tetapi untuk mendaftar, membayar, dan mengikuti kelas Anda perlu membuat akun terlebih dahulu.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                Bagaimana cara mendaftar kelas?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Cari kelas yang diinginkan → Klik <strong>Daftar</strong> → Lakukan pembayaran → Setelah pembayaran berhasil, Anda bisa langsung mengakses materi di dashboard member.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                Metode pembayaran apa saja yang tersedia?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                LearnServe mendukung berbagai metode pembayaran melalui Midtrans/Xendit, termasuk transfer bank, e-wallet, dan kartu kredit/debit.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                Apakah saya bisa belajar lewat HP?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya. Website LearnServe sudah responsif sehingga bisa diakses melalui laptop, tablet, maupun smartphone.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                Bagaimana cara melacak progress belajar saya?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Progress belajar ditampilkan di dashboard member. Progress akan otomatis bertambah setiap kali Anda menyelesaikan materi atau mengumpulkan tugas.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 7 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                                Apakah saya mendapat sertifikat setelah menyelesaikan kelas?
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya. Sertifikat digital akan otomatis dibuat dan bisa diunduh setelah Anda menyelesaikan semua materi dan tugas sesuai ketentuan kelas.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 8 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                                Bagaimana jika saya mengalami kendala (akses materi, pembayaran, atau tugas)?
                            </button>
                        </h2>
                        <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat menghubungi <strong>Support Center</strong> melalui menu bantuan di dashboard atau mengirim pesan langsung ke tim customer service.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 9 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9">
                                Apakah ada kelas gratis di LearnServe?
                            </button>
                        </h2>
                        <div id="collapse9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya. Beberapa kelas tersedia secara gratis, Anda bisa menemukannya melalui menu pencarian dan filter.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 10 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10">
                                Apakah saya bisa berinteraksi dengan tutor atau peserta lain?
                            </button>
                        </h2>
                        <div id="collapse10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya. Ada fitur <strong>chat real-time</strong> dan <strong>forum diskusi</strong> yang bisa digunakan untuk komunikasi dengan tutor maupun sesama member.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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

