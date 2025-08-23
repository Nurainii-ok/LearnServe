@extends('layouts.app')

@section('title', 'Home - LearnServe')

@section('content')
<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #f8fafc;
    color: #334155;
  }

  /* Color Variables */
  :root {
    --primary: #93c5fd; /* Soft blue */
    --primary-dark: #3b82f6; /* Slightly darker blue */
    --light: #f8fafc;
    --dark: #1e293b;
    --gray: #64748b;
    --light-gray: #e2e8f0;
  }

  /* Hero Section */
    .hero {
      background: linear-gradient(90deg, #5a67d8, #805ad5);
      border-radius: 12px;
      padding: 60px 40px;
      color: white;
    }
    .hero h1 {
      font-weight: bold;
    }
    .hero p {
      font-size: 1.1rem;
      margin-top: 15px;
    }
    .hero img {
      max-width: 100%;
      border-radius: 10px;
    }

  .user-count {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    padding: 12px 24px;
    display: inline-flex;
    align-items: center;
    margin-bottom: 2rem;
  }

  .user-avatars {
    display: flex;
    margin-right: 12px;
  }

  .user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid white;
    margin-left: -8px;
    background: var(--primary-dark);
  }

  .user-avatar:first-child {
    margin-left: 0;
  }

  .section-badge {
    background: #eff6ff;
    color: var(--primary-dark);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 1rem;
  }

  .category-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid var(--light-gray);
    height: 100%;
  }

  .category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(147, 197, 253, 0.1);
    border-color: var(--primary);
  }

  .category-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 24px;
    background: #eff6ff;
    color: var(--primary-dark);
  }

  .category-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 8px;
  }

  .category-desc {
    font-size: 0.875rem;
    color: var(--gray);
    line-height: 1.5;
  }

  .popular-course {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid var(--light-gray);
  }

  .popular-course:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(147, 197, 253, 0.1);
    border-color: var(--primary);
  }

  .course-image {
    height: 200px;
    background: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
  }

  .course-content {
    padding: 24px;
  }

  .course-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 8px;
  }

  .course-desc {
    color: var(--gray);
    margin-bottom: 16px;
  }

  .course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .course-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #f59e0b;
  }

  .course-price {
    font-weight: 600;
    color: var(--primary-dark);
  }

  .promo-section {
    background: var(--primary);
    border-radius: 24px;
    padding: 60px 40px;
    text-align: center;
    color: white;
    margin: 60px auto;
    max-width: 1000px;
    position: relative;
    overflow: hidden;
  }

  .promo-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
  }

  /* Kenapa Memilih LearnServe */
    .why-section {
      margin-top: 80px;
    }
    .why-section h2 {
      font-weight: bold;
      text-align: center;
      margin-bottom: 40px;
    }
    .card-custom {
      border-radius: 12px;
      padding: 25px;
      background: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      text-align: center;
      transition: 0.3s;
    }
    .card-custom:hover {
      transform: translateY(-5px);
    }
    .card-custom h5 {
      font-weight: bold;
      margin-top: 15px;
    }

  .testimonial-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid var(--light-gray);
  }

  .testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(147, 197, 253, 0.1);
  }

  .testimonial-text {
    font-size: 1.125rem;
    color: var(--gray);
    font-style: italic;
    margin-bottom: 24px;
    line-height: 1.6;
  }

  .testimonial-author {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .author-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 12px;
  }

  .author-name {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 4px;
  }

  .author-role {
    font-size: 0.875rem;
    color: var(--gray);
  }

  .btn-primary-custom {
    background: var(--primary-dark);
    border: none;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.125rem;
    transition: all 0.3s ease;
    color: white;
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    background: #2563eb;
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1rem;
  }

  .section-subtitle {
    font-size: 1.125rem;
    color: var(--gray);
    margin-bottom: 3rem;
  }

  .btn-outline-light {
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    border: 2px solid rgba(255,255,255,0.5);
    background: transparent;
    color: white;
    transition: all 0.3s ease;
  }

  .btn-outline-light:hover {
    background: rgba(255,255,255,0.1);
  }

  @media (max-width: 768px) {
    .hero-section h1 {
      font-size: 2.5rem;
    }
    .hero-section {
      padding: 60px 20px;
    }
    .section-title {
      font-size: 2rem;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
        }
      });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.category-card, .popular-course, .testimonial-card').forEach(card => {
      observer.observe(card);
    });

    // Add click animation to category cards
    document.querySelectorAll('.category-card').forEach(card => {
      card.addEventListener('click', function() {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
          this.style.transform = 'translateY(-5px)';
        }, 150);
      });
    });
  });

  // Add CSS animations
  const style = document.createElement('style');
  style.textContent = `
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  `;
  document.head.appendChild(style);
</script>

<!-- Hero Section -->
    <section class="hero row align-items-center">
      <div class="col-md-6">
        <h1>Belajar dan Berkembang Bersama <br> <span style="color: #ffeb3b;">LearnServe</span></h1>
        <p>Platform pembelajaran online dengan bootcamp dan e-learning terbaik untuk meningkatkan skill digitalmu.</p>
        <a href="#" class="btn btn-light btn-lg mt-3">Mulai Sekarang</a>
      </div>
      <div class="col-md-6 text-center">
        <img src="" alt="Ilustrasi Belajar">
      </div>
    </section>

<!-- Categories Section -->
<section class="container" style="margin-bottom: 80px;">
  <div class="text-center" style="margin-bottom: 50px;">
    <span class="section-badge">⭐ Top Categories</span>
    <h2 class="section-title">Browse Courses</h2>
    <p class="section-subtitle">Catching up the on demand skills and high paying career this year</p>
  </div>

  <div class="row g-4">
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          💻
        </div>
        <div class="category-title">Software Development</div>
        <div class="category-desc">Learn modern programming languages and frameworks</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          📱
        </div>
        <div class="category-title">Digital Marketing</div>
        <div class="category-desc">Master digital marketing strategies and tools</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          📊
        </div>
        <div class="category-title">Business Intelligence</div>
        <div class="category-desc">Analyze data and make informed business decisions</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          🚀
        </div>
        <div class="category-title">Freelancing Journey</div>
        <div class="category-desc">Build successful freelance career from scratch</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          📈
        </div>
        <div class="category-title">Product & Customer Data Analytics</div>
        <div class="category-desc">Understand customer behavior through data</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          🎨
        </div>
        <div class="category-title">UX Design Copywriting</div>
        <div class="category-desc">Create engaging user experiences and content</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          🔍
        </div>
        <div class="category-title">Software Quality Assurance</div>
        <div class="category-desc">Ensure software quality through testing</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon">
          💼
        </div>
        <div class="category-title">Business</div>
        <div class="category-desc">Develop essential business and leadership skills</div>
      </div>
    </div>
  </div>
</section>

<!-- Popular Courses Section -->
<section class="container" style="margin-bottom: 80px;">
  <div class="row align-items-center" style="margin-bottom: 40px;">
    <div class="col">
      <h2 class="section-title" style="margin-bottom: 0;">Kelas Populer</h2>
      <p class="section-subtitle" style="margin-bottom: 0;">Kelas terpopuler yang banyak diminati siswa</p>
    </div>
    <div class="col-auto">
      <a href="#" style="color: var(--primary-dark); font-weight: 600; text-decoration: none;">Lihat Semua →</a>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-4 col-md-6">
      <div class="popular-course">
        <div class="course-image">
          🌐
        </div>
        <div class="course-content">
          <div class="course-title">Full Stack Web Development</div>
          <div class="course-desc">Belajar membuat website modern dengan teknologi terbaru dari frontend hingga backend</div>
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
        <div class="course-image">
          🎨
        </div>
        <div class="course-content">
          <div class="course-title">UI/UX Design Mastery</div>
          <div class="course-desc">Membuat desain aplikasi yang menarik dan user-friendly dengan tools professional</div>
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
        <div class="course-image">
          📱
        </div>
        <div class="course-content">
          <div class="course-title">Digital Marketing Pro</div>
          <div class="course-desc">Optimasi bisnis melalui internet dengan strategi marketing digital yang efektif</div>
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

{{-- Kenapa Memilih LearnServe --}}
    <section class="why-section">
      <h2>Kenapa Memilih LearnServe?</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card-custom">
            <img src="https://img.icons8.com/color/96/learning.png" alt="Materi Lengkap">
            <h5>Materi Lengkap</h5>
            <p>Kami menyediakan materi terbaru dan terupdate sesuai kebutuhan industri saat ini.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-custom">
            <img src="https://img.icons8.com/color/96/training.png" alt="Mentor Berpengalaman">
            <h5>Mentor Berpengalaman</h5>
            <p>Dibimbing langsung oleh para praktisi profesional di bidangnya masing-masing.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-custom">
            <img src="https://img.icons8.com/color/96/certificate.png" alt="Sertifikat Resmi">
            <h5>Sertifikat Resmi</h5>
            <p>Dapatkan sertifikat yang dapat meningkatkan portofolio dan peluang kariermu.</p>
          </div>
        </div>
      </div>
    </section>

<!-- Testimonials Section -->
<section class="container" style="margin-bottom: 80px;">
  <div class="text-center" style="margin-bottom: 50px;">
    <h2 class="section-title">Testimoni Student</h2>
    <p class="section-subtitle">Apa kata mereka yang sudah bergabung dengan LearnServe</p>
  </div>

  <div class="row g-4">
    <div class="col-lg-4 col-md-6">
      <div class="testimonial-card">
        <div class="testimonial-text">
          "Platform ini benar-benar mengubah karir saya. Materinya lengkap dan mudah dipahami. Sekarang saya sudah bekerja sebagai Full Stack Developer!"
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
          "Instrukturnya sangat berpengalaman dan sabar. Saya yang awalnya nol pengetahuan tentang design, sekarang bisa freelance UI/UX."
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
          "Bootcamp digital marketing di sini sangat worth it! Bisnis online saya sekarang berkembang pesat berkat ilmu yang didapat."
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

@endsection