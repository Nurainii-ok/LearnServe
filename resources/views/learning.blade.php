@extends('layouts.app')
@section('title', 'Bootcamp & Program')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnServe - Bootcamp & Program</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #2c2c2c;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Color Variables */
        :root {
            --primary-gold: #ecac57;
            --primary-brown: #944e25;
            --light-cream: #f3efec;
            --deep-brown: #6b3419;
            --soft-gold: #f4d084;
            --text-primary: #2c2c2c;
            --text-secondary: #666666;
            --text-light: #8a8a8a;
            --bg-light: #ffffff;
            --bg-section: #f8f8f8;
            --success-green: #4a7c59;
            --info-blue: #5b7c8a;
            --alert-orange: #d97435;
            --border-light: #e8e8e8;
            --shadow-light: rgba(0, 0, 0, 0.06);
            --shadow-hover: rgba(0, 0, 0, 0.12);
            --gradient-gold: linear-gradient(135deg, var(--primary-gold), var(--soft-gold));
            --gradient-brown: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
        }

        /* Hero Section */
        .hero {
            padding: 140px 0 100px;
            background: linear-gradient(135deg, var(--light-cream) 0%, #ffffff 50%, var(--bg-section) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: var(--gradient-gold);
            opacity: 0.03;
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            max-width: 600px;
            font-weight: 400;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-brown);
            display: block;
            line-height: 1;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: var(--gradient-gold);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            background: var(--gradient-brown);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(236, 172, 87, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            color: var(--text-primary);
            padding: 1rem 2.5rem;
            border: 2px solid var(--border-light);
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary-custom:hover {
            border-color: var(--primary-gold);
            color: var(--primary-brown);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--shadow-hover);
        }

        /* Popular Classes Section */
        .popular-section {
            padding: 100px 0;
            background: var(--bg-light);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 0.75rem 1.5rem;
            background: white;
            border: 2px solid var(--border-light);
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: var(--text-secondary);
            position: relative;
            overflow: hidden;
        }

        .filter-tab::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-gold);
            transition: left 0.3s ease;
            z-index: 1;
        }

        .filter-tab span {
            position: relative;
            z-index: 2;
        }

        .filter-tab.active,
        .filter-tab:hover {
            color: white;
            border-color: var(--primary-gold);
            transform: translateY(-2px);
        }

        .filter-tab.active::before,
        .filter-tab:hover::before {
            left: 0;
        }

        /* Course Cards */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .course-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 6px 30px var(--shadow-light);
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid var(--border-light);
        }

        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-gold);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px var(--shadow-hover);
        }

        .course-card:hover::before {
            transform: scaleX(1);
        }

        .course-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .course-card:hover .course-image img {
            transform: scale(1.1);
        }

        .course-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--gradient-gold);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .course-content {
            padding: 1.5rem;
        }

        .course-category {
            color: var(--primary-gold);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .course-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .course-instructor {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: var(--text-secondary);
        }

        .course-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .stat-group {
            display: flex;
            gap: 1rem;
        }

        .stat-small {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .course-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-brown);
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: var(--gradient-brown);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-100px, -100px) rotate(360deg); }
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-cta {
            background: white;
            color: var(--primary-brown);
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            color: var(--primary-brown);
        }

        /* Animation Classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in-up.animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .hero-stats {
                gap: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .filter-tabs {
                gap: 0.3rem;
            }

            .filter-tab {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-title {
                font-size: 2rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="fade-in-up">Kuasai Skill Digital<br>dengan <span style="color: var(--primary-gold);">Expert</span></h1>
                        <p class="hero-subtitle fade-in-up">Bergabunglah dengan ribuan profesional yang telah mengembangkan karir mereka melalui bootcamp dan kursus berkualitas tinggi dari para ahli industri.</p>
                        
                        <div class="hero-stats fade-in-up">
                            <div class="stat-item">
                                <span class="stat-number">50K+</span>
                                <span class="stat-label">Alumni</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">95%</span>
                                <span class="stat-label">Job Placement</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">200+</span>
                                <span class="stat-label">Kursus</span>
                            </div>
                        </div>

                        <div class="hero-buttons fade-in-up">
                            <a href="#courses" class="btn-primary-custom">
                                <i class="fas fa-play"></i>
                                Mulai Belajar
                            </a>
                            <a href="#" class="btn-secondary-custom">
                                <i class="fas fa-info-circle"></i>
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Classes Section -->
    <section id="courses" class="popular-section">
        <div class="container">
            

            <!-- Filter Tabs -->
            <div class="filter-tabs fade-in-up">
                <div class="filter-tab active" data-category="all">
                    <span>Semua Kelas</span>
                </div>
                <div class="filter-tab" data-category="programming">
                    <span>Programming</span>
                </div>
                <div class="filter-tab" data-category="design">
                    <span>Design</span>
                </div>
                <div class="filter-tab" data-category="business">
                    <span>Business</span>
                </div>
                <div class="filter-tab" data-category="data">
                    <span>Data Science</span>
                </div>
            </div>

            <!-- Courses Grid -->
            <div class="courses-grid fade-in-up">
                <!-- Course 1 -->
                <div class="course-card" data-category="programming">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=200&fit=crop" alt="Full Stack Development">
                        <div class="course-badge">Trending</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Programming</div>
                        <h3 class="course-title">Full Stack Web Development</h3>
                        <div class="course-instructor">
                            <i class="fas fa-user-circle"></i>
                            <span>Ahmad Rizki, Senior Developer</span>
                        </div>
                        <div class="course-stats">
                            <div class="stat-group">
                                <div class="stat-small">
                                    <i class="fas fa-users"></i>
                                    <span>15,240</span>
                                </div>
                                <div class="stat-small">
                                    <i class="fas fa-star"></i>
                                    <span>4.9</span>
                                </div>
                            </div>
                            <div class="course-price">Rp 2,500K</div>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="course-card" data-category="design">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=400&h=200&fit=crop" alt="UI/UX Design">
                        <div class="course-badge">Popular</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Design</div>
                        <h3 class="course-title">UI/UX Design Mastery</h3>
                        <div class="course-instructor">
                            <i class="fas fa-user-circle"></i>
                            <span>Sarah Designer, Design Lead</span>
                        </div>
                        <div class="course-stats">
                            <div class="stat-group">
                                <div class="stat-small">
                                    <i class="fas fa-users"></i>
                                    <span>12,890</span>
                                </div>
                                <div class="stat-small">
                                    <i class="fas fa-star"></i>
                                    <span>4.8</span>
                                </div>
                            </div>
                            <div class="course-price">Rp 2,200K</div>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="course-card" data-category="data">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=200&fit=crop" alt="Data Science">
                        <div class="course-badge">Hot</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Data Science</div>
                        <h3 class="course-title">Data Science & Analytics</h3>
                        <div class="course-instructor">
                            <i class="fas fa-user-circle"></i>
                            <span>Dr. Budi Santoso, Data Scientist</span>
                        </div>
                        <div class="course-stats">
                            <div class="stat-group">
                                <div class="stat-small">
                                    <i class="fas fa-users"></i>
                                    <span>9,560</span>
                                </div>
                                <div class="stat-small">
                                    <i class="fas fa-star"></i>
                                    <span>4.9</span>
                                </div>
                            </div>
                            <div class="course-price">Rp 3,000K</div>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="course-card" data-category="business">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=200&fit=crop" alt="Digital Marketing">
                        <div class="course-badge">New</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Business</div>
                        <h3 class="course-title">Digital Marketing Pro</h3>
                        <div class="course-instructor">
                            <i class="fas fa-user-circle"></i>
                            <span>Lisa Marketing, CMO</span>
                        </div>
                        <div class="course-stats">
                            <div class="stat-group">
                                <div class="stat-small">
                                    <i class="fas fa-users"></i>
                                    <span>11,200</span>
                                </div>
                                <div class="stat-small">
                                    <i class="fas fa-star"></i>
                                    <span>4.7</span>
                                </div>
                            </div>
                            <div class="course-price">Rp 1,800K</div>
                        </div>
                    </div>
                </div>

                <!-- Course 5 -->
                <div class="course-card" data-category="programming">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400&h=200&fit=crop" alt="Mobile Development">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Programming</div>
                        <h3 class="course-title">Mobile App Development</h3>
                        <div class="course-instructor">
                            <i class="fas fa-user-circle"></i>
                            <span>Andi Mobile, Tech Lead</span>
                        </div>
                        <div class="course-stats">
                            <div class="stat-group">
                                <div class="stat-small">
                                    <i class="fas fa-users"></i>
                                    <span>8,430</span>
                                </div>
                                <div class="stat-small">
                                    <i class="fas fa-star"></i>
                                    <span>4.8</span>
                                </div>
                            </div>
                            <div class="course-price">Rp 2,800K</div>
                        </div>
                    </div>
                </div>

                <!-- Course 6 -->
                <div class="course-card" data-category="design">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=200&fit=crop" alt="Graphic Design">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Design</div>
                        <h3 class="course-title">Professional Graphic Design</h3>
                        <div class="course-instructor">
                            <i class="fas fa-user-circle"></i>
                            <span>Maya Creative, Art Director</span>
                        </div>
                        <div class="course-stats">
                            <div class="stat-group">
                                <div class="stat-small">
                                    <i class="fas fa-users"></i>
                                    <span>7,890</span>
                                </div>
                                <div class="stat-small">
                                    <i class="fas fa-star"></i>
                                    <span>4.6</span>
                                </div>
                            </div>
                            <div class="course-price">Rp 1,900K</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in-up">
                <h2 class="cta-title">Siap Memulai Perjalanan Karirmu?</h2>
                <p class="cta-subtitle">Bergabunglah dengan komunitas pembelajar terbesar di Indonesia dan raih impianmu bersama mentor terbaik!</p>
                <a href="#" class="btn-cta">
                    <i class="fas fa-rocket"></i>
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Filter functionality
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');

                const category = this.getAttribute('data-category');
                const cards = document.querySelectorAll('.course-card');

                cards.forEach((card, index) => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 100);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        // Observe all fade-in-up elements
        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Course card hover effects
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Initialize animations on page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.querySelectorAll('.fade-in-up').forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('animate');
                    }, index * 200);
                });
            }, 100);
        });

        // Add click ripple effect to buttons
        document.querySelectorAll('.btn-primary-custom, .btn-secondary-custom, .btn-nav, .btn-cta').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>