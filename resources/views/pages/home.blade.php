@extends('layouts.app')
@section('title', 'Home')
@section('title', 'Bootcamp & Program')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

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

<!--<div class="container-fluid px-4">-->
    <!-- Popular Category Section -->
    <section class="popular-category py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">Popular Category</h5>
        <a href="#" class="text-decoration-none fw-semibold">View all categories</a>
        </div>
        <!--<p class="text-muted small mb-4">2020 jobs live – 293 added today.</p>-->

        <!-- Categories Row -->
        <div class="row g-3">
        <!-- Category Card -->
        <div class="col-6 col-md-3">
            <div class="category-card h-100 shadow-sm">
            <div class="icon-box">
                <i class="bi bi-code-slash"></i>
            </div>
            <h6 class="fw-semibold">Development & IT</h6>
            <p class="small text-muted mb-1">16 jobs</p>
            <p class="small text-muted">Frontend, backend, web and app developer jobs.</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="category-card h-100 shadow-sm">
            <div class="icon-box">
                <i class="bi bi-bullseye"></i>
            </div>
            <h6 class="fw-semibold">Marketing & Sales</h6>
            <p class="small text-muted mb-1">8 jobs</p>
            <p class="small text-muted">Advertising, digital marketing and brand...</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="category-card h-100 shadow-sm">
            <div class="icon-box">
                <i class="bi bi-palette"></i>
            </div>
            <h6 class="fw-semibold">Design & Creative</h6>
            <p class="small text-muted mb-1">13 jobs</p>
            <p class="small text-muted">Graphic, digital, web, and product design jobs.</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="category-card h-100 shadow-sm">
            <div class="icon-box">
                <i class="bi bi-people"></i>
            </div>
            <h6 class="fw-semibold">Customer Service</h6>
            <p class="small text-muted mb-1">8 jobs</p>
            <p class="small text-muted">Customer experience and account management jobs.</p>
            </div>
        </div>
        </div>
    </div>
    </section>



    <section class="all-courses-section py-5" style="background-color: #ffecc7;">
    <div class="container">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">
            <span style="color: #944e25;">Kelas</span> Populer
        </h2>
        <div class="search-box">
            <input type="text" class="form-control" placeholder="Search your course">
            <button class="btn btn-link p-0">
            <i class="bi bi-search"></i>
            </button>
        </div>
        </div>

        <!-- Filter -->
        <div class="d-flex flex-wrap gap-2 mb-5">
        <button class="btn btn-light active">UI/UX Design</button>
        <button class="btn btn-light">Development</button>
        <button class="btn btn-light">Data Science</button>
        <button class="btn btn-light">Business</button>
        <button class="btn btn-light">Financial</button>
        </div>
<!-- Courses Grid -->
<div class="row g-4">
  <!-- Course Card -->
  <div class="col-lg-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm course-card">
      <!-- Image -->
      <div class="position-relative">
        <img src="assets/Data Analytics.jpg" class="card-img-top rounded-top" alt="Course">
        <!-- Optional: label diskon -->
        <span class="badge bg-danger position-absolute top-0 end-0 m-2">-15%</span>
      </div>

      <!-- Body -->
      <div class="card-body">
        <!-- Instructor -->
        <div class="d-flex align-items-center mb-3">
          <img src="assets/avatar1.jpg" class="rounded-circle" width="40" height="40" alt="Instructor">
          <div class="ms-2 small">
            <div class="fw-semibold">Jason Williams</div>
            <div class="badge bg-success-subtle text-success">Science</div>
          </div>
        </div>

        <!-- Title -->
        <h6 class="fw-semibold mb-2 text-truncate" title="Data Science and Machine Learning with Python - Hands On!">
          Data Science and Machine Learning with Python - Hands On!
        </h6>

        <!-- Meta -->
        <div class="d-flex justify-content-between small text-muted mb-3">
          <span><i class="bi bi-clock"></i> 8h 15m</span>
          <span><i class="bi bi-play-circle"></i> 29 Lectures</span>
        </div>

        <!-- Price & Rating -->
        <div class="d-flex justify-content-between align-items-center">
          <div class="price">
            <span class="text-success fw-bold">$385.00</span>
            <span class="text-decoration-line-through text-muted small ms-1">$440.00</span>
          </div>
          <div class="rating text-warning fw-semibold">
            <i class="bi bi-star-fill"></i> 4.9
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Course Card -->
  <div class="col-lg-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm course-card">
      <!-- Image -->
      <div class="position-relative">
        <img src="assets/Data Analytics.jpg" class="card-img-top rounded-top" alt="Course">
        <!-- Optional: label diskon -->
        <span class="badge bg-danger position-absolute top-0 end-0 m-2">-15%</span>
      </div>

      <!-- Body -->
      <div class="card-body">
        <!-- Instructor -->
        <div class="d-flex align-items-center mb-3">
          <img src="assets/avatar1.jpg" class="rounded-circle" width="40" height="40" alt="Instructor">
          <div class="ms-2 small">
            <div class="fw-semibold">Jason Williams</div>
            <div class="badge bg-success-subtle text-success">Science</div>
          </div>
        </div>

        <!-- Title -->
        <h6 class="fw-semibold mb-2 text-truncate" title="Data Science and Machine Learning with Python - Hands On!">
          Data Science and Machine Learning with Python - Hands On!
        </h6>

        <!-- Meta -->
        <div class="d-flex justify-content-between small text-muted mb-3">
          <span><i class="bi bi-clock"></i> 8h 15m</span>
          <span><i class="bi bi-play-circle"></i> 29 Lectures</span>
        </div>

        <!-- Price & Rating -->
        <div class="d-flex justify-content-between align-items-center">
          <div class="price">
            <span class="text-success fw-bold">$385.00</span>
            <span class="text-decoration-line-through text-muted small ms-1">$440.00</span>
          </div>
          <div class="rating text-warning fw-semibold">
            <i class="bi bi-star-fill"></i> 4.9
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Course Card -->
  <div class="col-lg-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm course-card">
      <!-- Image -->
      <div class="position-relative">
        <img src="assets/Data Analytics.jpg" class="card-img-top rounded-top" alt="Course">
        <!-- Optional: label diskon -->
        <span class="badge bg-danger position-absolute top-0 end-0 m-2">-15%</span>
      </div>

      <!-- Body -->
      <div class="card-body">
        <!-- Instructor -->
        <div class="d-flex align-items-center mb-3">
          <img src="assets/avatar1.jpg" class="rounded-circle" width="40" height="40" alt="Instructor">
          <div class="ms-2 small">
            <div class="fw-semibold">Jason Williams</div>
            <div class="badge bg-success-subtle text-success">Science</div>
          </div>
        </div>

        <!-- Title -->
        <h6 class="fw-semibold mb-2 text-truncate" title="Data Science and Machine Learning with Python - Hands On!">
          Data Science and Machine Learning with Python - Hands On!
        </h6>

        <!-- Meta -->
        <div class="d-flex justify-content-between small text-muted mb-3">
          <span><i class="bi bi-clock"></i> 8h 15m</span>
          <span><i class="bi bi-play-circle"></i> 29 Lectures</span>
        </div>

        <!-- Price & Rating -->
        <div class="d-flex justify-content-between align-items-center">
          <div class="price">
            <span class="text-success fw-bold">$385.00</span>
            <span class="text-decoration-line-through text-muted small ms-1">$440.00</span>
          </div>
          <div class="rating text-warning fw-semibold">
            <i class="bi bi-star-fill"></i> 4.9
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Copy card ini 5x lagi untuk course lain -->
</div>


        <!-- Button -->
        <div class="text-center mt-5">
    <a href="{{ route('learning') }}" class="btn btn-outline-success px-4">
        Other Course
    </a>
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
        <div class="container">
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
<!--</div>-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
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

