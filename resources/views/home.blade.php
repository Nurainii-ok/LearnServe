@extends('layouts.app')

@section('title', 'Home - LearnServe')

@section('content')
<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #f8fafc;
  }

  .hero-section {
    background: linear-gradient(135deg, #7494ec 0%, #5a67d8 100%);
    border-radius: 24px;
    padding: 80px 40px;
    margin: 40px auto;
    max-width: 1200px;
    position: relative;
    overflow: hidden;
  }

  .hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
    pointer-events: none;
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-section h1 {
    font-size: 3.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1.5rem;
    line-height: 1.2;
  }

  .hero-section p {
    font-size: 1.25rem;
    color: #e2e8f0;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .user-count {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 12px 24px;
    display: inline-flex;
    align-items: center;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
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
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
  }

  .user-avatar:first-child {
    margin-left: 0;
  }

  .section-badge {
    background: #fff5f5;
    color: #e53e3e;
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
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid #f1f5f9;
    height: 100%;
  }

  .category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(116, 148, 236, 0.15);
    border-color: #7494ec;
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
  }

  .category-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 8px;
  }

  .category-desc {
    font-size: 0.875rem;
    color: #64748b;
    line-height: 1.5;
  }

  .popular-course {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .popular-course:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(116, 148, 236, 0.15);
  }

  .course-image {
    height: 200px;
    background: linear-gradient(135deg, #7494ec, #a78bfa);
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
    color: #1a202c;
    margin-bottom: 8px;
  }

  .course-desc {
    color: #64748b;
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
    color: #7494ec;
  }

  .promo-section {
    background: linear-gradient(135deg, #7494ec 0%, #5a67d8 100%);
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

  .promo-content {
    position: relative;
    z-index: 2;
  }

  .testimonial-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
    transition: all 0.3s ease;
  }

  .testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(116, 148, 236, 0.1);
  }

  .testimonial-text {
    font-size: 1.125rem;
    color: #4a5568;
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
    background: linear-gradient(135deg, #7494ec, #a78bfa);
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
    color: #1a202c;
    margin-bottom: 4px;
  }

  .author-role {
    font-size: 0.875rem;
    color: #64748b;
  }

  .btn-primary-custom {
    background: linear-gradient(135deg, #7494ec, #5a67d8);
    border: none;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.125rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(116, 148, 236, 0.3);
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(116, 148, 236, 0.4);
    background: linear-gradient(135deg, #5a67d8, #4c51bf);
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 1rem;
  }

  .section-subtitle {
    font-size: 1.125rem;
    color: #64748b;
    margin-bottom: 3rem;
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
    // Animate category cards on scroll
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
          this.style.transform = 'translateY(-8px)';
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
        transform: translateY(30px);
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
<section class="hero-section text-center">
  <div class="hero-content">
    <div class="user-count">
      <div class="user-avatars">
        <div class="user-avatar"></div>
        <div class="user-avatar"></div>
        <div class="user-avatar"></div>
      </div>
      <span style="color: white; font-weight: 500;">Join 3 million users</span>
    </div>
    <h1>Build Future <span style="color: #a78bfa;">Career.</span></h1>
    <p>LearnServe provides high quality online courses for you to grow your skills and build outstanding portfolio to tackle job interviews</p>
    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
      <button class="btn btn-primary-custom">Explore Courses</button>
      <button class="btn btn-outline-light" style="padding: 16px 32px; border-radius: 12px; font-weight: 600; border: 2px solid rgba(255,255,255,0.3);">Career Guidance</button>
    </div>
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
        <div class="category-icon" style="background: linear-gradient(135deg, #7494ec, #a78bfa);">
          💻
        </div>
        <div class="category-title">Software Development</div>
        <div class="category-desc">Learn modern programming languages and frameworks</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
          📱
        </div>
        <div class="category-title">Digital Marketing</div>
        <div class="category-desc">Master digital marketing strategies and tools</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
          📊
        </div>
        <div class="category-title">Business Intelligence</div>
        <div class="category-desc">Analyze data and make informed business decisions</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
          🚀
        </div>
        <div class="category-title">Freelancing Journey</div>
        <div class="category-desc">Build successful freelance career from scratch</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
          📈
        </div>
        <div class="category-title">Product & Customer Data Analytics</div>
        <div class="category-desc">Understand customer behavior through data</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
          🎨
        </div>
        <div class="category-title">UX Design Copywriting</div>
        <div class="category-desc">Create engaging user experiences and content</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
          🔍
        </div>
        <div class="category-title">Software Quality Assurance</div>
        <div class="category-desc">Ensure software quality through testing</div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="category-card">
        <div class="category-icon" style="background: linear-gradient(135deg, #ffecd2, #fcb69f);">
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
      <p style="color: #64748b; font-size: 1.125rem;">Kelas terpopuler yang banyak diminati siswa</p>
    </div>
    <div class="col-auto">
      <a href="#" style="color: #7494ec; font-weight: 600; text-decoration: none;">Lihat Semua →</a>
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
              <span style="color: #1a202c; font-weight: 500;">4.8 (2.1k)</span>
            </div>
            <div class="course-price">Rp 299.000</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
      <div class="popular-course">
        <div class="course-image" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
          🎨
        </div>
        <div class="course-content">
          <div class="course-title">UI/UX Design Mastery</div>
          <div class="course-desc">Membuat desain aplikasi yang menarik dan user-friendly dengan tools professional</div>
          <div class="course-meta">
            <div class="course-rating">
              <span>⭐</span>
              <span style="color: #1a202c; font-weight: 500;">4.9 (1.8k)</span>
            </div>
            <div class="course-price">Rp 399.000</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
      <div class="popular-course">
        <div class="course-image" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
          📱
        </div>
        <div class="course-content">
          <div class="course-title">Digital Marketing Pro</div>
          <div class="course-desc">Optimasi bisnis melalui internet dengan strategi marketing digital yang efektif</div>
          <div class="course-meta">
            <div class="course-rating">
              <span>⭐</span>
              <span style="color: #1a202c; font-weight: 500;">4.7 (1.5k)</span>
            </div>
            <div class="course-price">Rp 249.000</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Promo Section -->
<section class="promo-section">
  <div class="promo-content">
    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Promo Spesial Akhir Tahun!</h2>
    <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9;">Dapatkan diskon hingga 50% untuk semua kelas Bootcamp dan sertifikasi gratis</p>
    <button class="btn btn-light" style="padding: 16px 32px; border-radius: 12px; font-weight: 600; color: #7494ec; font-size: 1.125rem;">
      Claim Promo Sekarang
    </button>
  </div>
</section>

<!-- Testimonials Section -->
<section class="container" style="margin-bottom: 80px;">
  <div class="text-center" style="margin-bottom: 50px;">
    <h2 class="section-title">Testimoni Student</h2>
    <p class="section-subtitle">Apa kata mereka yang sudah bergabung dengan EduPlatform</p>
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