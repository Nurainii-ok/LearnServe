@extends('layouts.app')
@section('title', 'Home')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

<!-- Clean Hero Section -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <h1>Belajar dan Berkembang Bersama <br><span class="highlight">LearnServe</span></h1>
        <p>Platform pembelajaran online dengan bootcamp dan e-learning terbaik untuk meningkatkan skill digitalmu dan mewujudkan karir impianmu.</p>
      </div>
      <div class="col-lg-6 text-center">
        <img src="{{ asset('assets/img/illustrations/Bootcamp2.jpg') }}" 
             alt="Bootcamp Illustration" 
             style="width: 100%; height: 400px; object-fit: cover; border-radius: 20px;"
             loading="lazy">
      </div>
    </div>
  </div>
</section>

<section class="stats-section">
  <div class="stats-container">
    
    <!-- Item 1 -->
    <div class="stat-item">
      <div class="stat-icon">
        <img src="https://img.icons8.com/ios-filled/50/3b82f6/books.png" alt="courses" loading="lazy">
      </div>
      <div class="stat-text">
        <h2>10k+</h2>
        <p>Total Courses</p>
      </div>
    </div>

    <!-- Item 2 -->
    <div class="stat-item">
      <div class="stat-icon">
        <img src="https://img.icons8.com/ios-filled/50/f97316/classroom.png" alt="mentors" loading="lazy">
      </div>
      <div class="stat-text">
        <h2>500+</h2>
        <p>Expert Mentors</p>
      </div>
    </div>

    <!-- Item 3 -->
    <div class="stat-item">
      <div class="stat-icon">
        <img src="https://img.icons8.com/ios-filled/50/8b5cf6/conference.png" alt="students" loading="lazy">
      </div>
      <div class="stat-text">
        <h2>300k+</h2>
        <p>Students Globally</p>
      </div>
    </div>

  </div>
</section>

<!--<div class="container-fluid px-4">-->
<!-- Explore Courses by Category -->
<section class="popular-category py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold">Explore courses by category</h3>
      <!--<a href="#" class="btn btn-outline-primary btn-sm">All Category</a>-->
    </div>
    <p class="text-muted mb-5">Browse top class courses by browsing our category which will be more easy for you.</p>

    <div class="row g-4">
      <!-- Category Card -->
      <div class="col-6 col-md-4 col-lg-4">
        <div class="category-card text-start">
          <div class="icon-box bg-soft-blue text-blue">
            <i class="bi bi-pen"></i>
          </div>
          <h6 class="fw-semibold">Design & Development</h6>
          <p class="small text-muted mb-0">250+ courses available</p>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-4">
        <div class="category-card text-start">
          <div class="icon-box bg-soft-purple text-purple">
            <i class="bi bi-megaphone"></i>
          </div>
          <h6 class="fw-semibold">Marketing & Communication</h6>
          <p class="small text-muted mb-0">300+ courses available</p>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-4">
        <div class="category-card text-start">
          <div class="icon-box bg-soft-orange text-orange">
            <i class="bi bi-laptop"></i>
          </div>
          <h6 class="fw-semibold">Digital Marketing</h6>
          <p class="small text-muted mb-0">150+ courses available</p>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-4">
        <div class="category-card text-start">
          <div class="icon-box bg-soft-red text-red">
            <i class="bi bi-briefcase"></i>
          </div>
          <h6 class="fw-semibold">Business & Consulting</h6>
          <p class="small text-muted mb-0">170+ courses available</p>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-4">
        <div class="category-card text-start">
          <div class="icon-box bg-soft-pink text-pink">
            <i class="bi bi-cash-coin"></i>
          </div>
          <h6 class="fw-semibold">Finance Management</h6>
          <p class="small text-muted mb-0">300+ courses available</p>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-4">
        <div class="category-card text-start">
          <div class="icon-box bg-soft-green text-green">
            <i class="bi bi-person"></i>
          </div>
          <h6 class="fw-semibold">Self Development</h6>
          <p class="small text-muted mb-0">50+ courses available</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Popular Courses Section -->
<section class="popular-courses-section py-5" style="background:#fcf9f7;">
  <div class="container">
    
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
      <div>
        <h3 class="fw-bold mb-1">Popular courses for you</h3>
        <p class="text-muted small mb-0">Get the best course with the best price with world-class tutors</p>
      </div>
        <a href="{{ route('learning') }}" 
            class="btn btn-sm custom-btn">
            See All Jobs
        </a>
    </div>

    <!-- Courses Grid -->
    <div class="row g-4">
      
      <!-- Course Card -->
      <div class="col-lg-4 col-md-6">
        <div class="course-card border-0 shadow-sm h-100">
          <!-- Image -->
          <div class="course-img">
            <img src="{{ asset('assets/img/illustrations/SEO.jpg') }}" alt="Course" class="w-100 rounded-top" loading="lazy">
          </div>

          <!-- Body -->
          <div class="p-3">
            <span class="badge bg-light text-primary mb-2">Digital Marketing</span>
            <h6 class="fw-semibold mb-3">Search Engine Optimization (SEO)</h6>
            
            <!-- Meta -->
            <div class="d-flex justify-content-between small text-muted">
              <span>500k+</span>
              <span>⭐ 4.9</span>
              <span class="fw-semibold text-dark">Rp 200.000</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Course Card -->
      <div class="col-lg-4 col-md-6">
        <div class="course-card border-0 shadow-sm h-100">
          <div class="course-img">
            <img src="{{ asset('assets/img/illustrations/motionGraphic.jpg') }}" alt="Course" class="w-100 rounded-top" loading="lazy">
          </div>
          <div class="p-3">
            <span class="badge bg-light text-success mb-2">Graphic Design</span>
            <h6 class="fw-semibold mb-3">Advance motion graphics</h6>
            <div class="d-flex justify-content-between small text-muted">
              <span>500k+</span>
              <span>⭐ 4.9</span>
              <span class="fw-semibold text-dark">$105.00</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Course Card -->
      <div class="col-lg-4 col-md-6">
        <div class="course-card border-0 shadow-sm h-100">
          <div class="course-img">
            <img src="{{ asset('assets/img/illustrations/CMS.jpg') }}" alt="Course" class="w-100 rounded-top" loading="lazy">
          </div>
          <div class="p-3">
            <span class="badge bg-light text-purple mb-2">Web Design</span>
            <h6 class="fw-semibold mb-3">Learn CMS Development</h6>
            <div class="d-flex justify-content-between small text-muted">
              <span>500k+</span>
              <span>⭐ 4.9</span>
              <span class="fw-semibold text-dark">$105.00</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tambah 3 card lagi biar grid = 6 seperti gambar -->
      <div class="col-lg-4 col-md-6">
        <div class="course-card border-0 shadow-sm h-100">
          <div class="course-img">
            <img src="{{ asset('assets/img/illustrations/webdesign2.jpg') }}" alt="Course" class="w-100 rounded-top" loading="lazy">
          </div>
          <div class="p-3">
            <span class="badge bg-light text-primary mb-2">Web Design</span>
            <h6 class="fw-semibold mb-3">The Complete Web Design course</h6>
            <div class="d-flex justify-content-between small text-muted">
              <span>500k+</span>
              <span>⭐ 4.9</span>
              <span class="fw-semibold text-dark">$105.00</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="course-card border-0 shadow-sm h-100">
          <div class="course-img">
            <img src="{{ asset('assets/course6.jpg') }}" alt="Course" class="w-100 rounded-top" loading="lazy">
          </div>
          <div class="p-3">
            <span class="badge bg-light text-danger mb-2">Art</span>
            <h6 class="fw-semibold mb-3">Advance Drawing</h6>
            <div class="d-flex justify-content-between small text-muted">
              <span>500k+</span>
              <span>⭐ 4.9</span>
              <span class="fw-semibold text-dark">$105.00</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="course-card border-0 shadow-sm h-100">
          <div class="course-img">
            <img src="{{ asset('assets/img/illustrations/Videography.jpg') }}" alt="Course" class="w-100 rounded-top" loading="lazy">
          </div>
          <div class="p-3">
            <span class="badge bg-light text-info mb-2">Media</span>
            <h6 class="fw-semibold mb-3">Advance videography course</h6>
            <div class="d-flex justify-content-between small text-muted">
              <span>500k+</span>
              <span>⭐ 4.9</span>
              <span class="fw-semibold text-dark">$105.00</span>
            </div>
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
                    <!--<img src="https://img.icons8.com/color/96/learning.png" alt="Materi Lengkap" loading="lazy">-->
                    <h5>Materi Terlengkap</h5>
                    <p>Kurikulum yang selalu update sesuai kebutuhan industri terkini dengan materi yang komprehensif dan praktis</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-custom">
                    <!--<img src="https://img.icons8.com/color/96/training.png" alt="Mentor Berpengalaman" loading="lazy">-->
                    <h5>Mentor Ahli</h5>
                    <p>Dibimbing langsung oleh para praktisi profesional dengan pengalaman bertahun-tahun di industri</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-custom">
                    <!--<img src="https://img.icons8.com/color/96/certificate.png" alt="Sertifikat Resmi" loading="lazy">-->
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
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Andi" class="author-avatar me-3" loading="lazy">
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
                        <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Siti" class="author-avatar me-3" loading="lazy">
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
                        <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Budi" class="author-avatar me-3" loading="lazy">
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

