@extends('layouts.app')

@section('title', 'Home - LearnServe')

@section('content')
    <div class="hero-section">
        <div class="container">
            <div class="header">
                <h1>Ratusan Skill Impian Kini Dalam Genggamanmu</h1>
                <p>Lihat contoh beberapa materi terpopuler rancangan experts berikut. Materi baru setiap bulan tanpa tambahan biaya.</p>
            </div>

            <!-- Filter kategori -->
            <div class="categories">
                <button class="category-tag active" data-category="all">Semua</button>
                <button class="category-tag" data-category="programming">Programming</button>
                <button class="category-tag" data-category="design">Design</button>
                <button class="category-tag" data-category="business">Business</button>
                <button class="category-tag" data-category="data">Data Science</button>
            </div>

            <!-- Grid Course -->
            <div class="courses-grid">
                <!-- Card 1 -->
                <div class="course-card" data-category="programming">
                    <div class="course-image">
                        <img src="https://picsum.photos/400/200?random=1" alt="Course Image">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Mastering Laravel 11 Belajar Toko</h3>
                        <div class="course-rating">
                            <span class="stars">⭐⭐⭐⭐⭐</span>
                            <small class="students-count">0 students</small>
                        </div>
                        <div class="course-footer">
                            <img class="tutor-img" src="https://i.pravatar.cc/40?img=5" alt="Tutor">
                            <div class="tutor-info">
                                <p class="tutor-name">Anne Belle</p>
                                <p class="tutor-role">Designer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="course-card" data-category="business">
                    <div class="course-image">
                        <img src="https://picsum.photos/400/201?random=2" alt="Course Image">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Manage Designer Passive Income</h3>
                        <div class="course-rating">
                            <span class="stars">⭐⭐⭐⭐</span>
                            <small class="students-count">2 students</small>
                        </div>
                        <div class="course-footer">
                            <img class="tutor-img" src="https://i.pravatar.cc/40?img=8" alt="Tutor">
                            <div class="tutor-info">
                                <p class="tutor-name">Rasiva</p>
                                <p class="tutor-role">Manager</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="course-card" data-category="design">
                    <div class="course-image">
                        <img src="https://picsum.photos/400/202?random=3" alt="Course Image">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">UI UX Design Psychology</h3>
                        <div class="course-rating">
                            <span class="stars">⭐⭐⭐⭐⭐</span>
                            <small class="students-count">2 students</small>
                        </div>
                        <div class="course-footer">
                            <img class="tutor-img" src="https://i.pravatar.cc/40?img=11" alt="Tutor">
                            <div class="tutor-info">
                                <p class="tutor-name">Alfrina</p>
                                <p class="tutor-role">Designer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 - Additional for better showcase -->
                <div class="course-card" data-category="data">
                    <div class="course-image">
                        <img src="https://picsum.photos/400/203?random=4" alt="Course Image">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Python Data Analysis Mastery</h3>
                        <div class="course-rating">
                            <span class="stars">⭐⭐⭐⭐⭐</span>
                            <small class="students-count">15 students</small>
                        </div>
                        <div class="course-footer">
                            <img class="tutor-img" src="https://i.pravatar.cc/40?img=15" alt="Tutor">
                            <div class="tutor-info">
                                <p class="tutor-name">Data Smith</p>
                                <p class="tutor-role">Data Scientist</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="course-card" data-category="programming">
                    <div class="course-image">
                        <img src="https://picsum.photos/400/204?random=5" alt="Course Image">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">React JS Modern Development</h3>
                        <div class="course-rating">
                            <span class="stars">⭐⭐⭐⭐</span>
                            <small class="students-count">8 students</small>
                        </div>
                        <div class="course-footer">
                            <img class="tutor-img" src="https://i.pravatar.cc/40?img=20" alt="Tutor">
                            <div class="tutor-info">
                                <p class="tutor-name">John React</p>
                                <p class="tutor-role">Frontend Developer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="course-card" data-category="design">
                    <div class="course-image">
                        <img src="https://picsum.photos/400/205?random=6" alt="Course Image">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">Figma to Code Workflow</h3>
                        <div class="course-rating">
                            <span class="stars">⭐⭐⭐⭐⭐</span>
                            <small class="students-count">12 students</small>
                        </div>
                        <div class="course-footer">
                            <img class="tutor-img" src="https://i.pravatar.cc/40?img=25" alt="Tutor">
                            <div class="tutor-info">
                                <p class="tutor-name">Sarah Design</p>
                                <p class="tutor-role">UI/UX Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="#" class="btn btn-primary">
                    <span>Mulai Berlangganan</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#" class="btn btn-secondary">Lihat Semua Materi</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1e293b;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            min-height: 100vh;
            padding: 80px 20px 40px;
            display: flex;
            align-items: center;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 32px;
            padding: 60px 50px;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
        }

        .header h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .header p {
            font-size: 1.25rem;
            color: #64748b;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .categories {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-bottom: 60px;
        }

        .category-tag {
            padding: 12px 24px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .category-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .category-tag:hover,
        .category-tag.active {
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .category-tag:hover::before,
        .category-tag.active::before {
            left: 0;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 60px;
        }

        .course-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f1f5f9;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
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
            transform: scale(1.05);
        }

        .course-content {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 16px;
            line-height: 1.4;
            flex: 1;
        }

        .course-rating {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .course-rating .stars {
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .students-count {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .course-footer {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tutor-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            object-fit: cover;
        }

        .tutor-info {
            flex: 1;
        }

        .tutor-name {
            margin: 0;
            font-weight: 600;
            font-size: 0.95rem;
            color: #1e293b;
        }

        .tutor-role {
            margin: 0;
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 2px;
        }

        .actions {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border-color: #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn svg {
            transition: transform 0.3s ease;
        }

        .btn:hover svg {
            transform: translateX(3px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 15px;
            }

            .container {
                padding: 40px 25px;
                border-radius: 20px;
            }

            .header h1 {
                font-size: 2.5rem;
            }

            .header p {
                font-size: 1.1rem;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .category-tag {
                font-size: 0.85rem;
                padding: 10px 18px;
            }

            .actions {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
                justify-content: center;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }

            .course-card {
                margin: 0 auto;
                max-width: 100%;
            }

            .categories {
                flex-direction: column;
                align-items: center;
            }

            .category-tag {
                width: 100%;
                max-width: 300px;
                text-align: center;
            }
        }

        /* Smooth animations */
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

        .course-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .course-card:nth-child(1) { animation-delay: 0.1s; }
        .course-card:nth-child(2) { animation-delay: 0.2s; }
        .course-card:nth-child(3) { animation-delay: 0.3s; }
        .course-card:nth-child(4) { animation-delay: 0.4s; }
        .course-card:nth-child(5) { animation-delay: 0.5s; }
        .course-card:nth-child(6) { animation-delay: 0.6s; }

        /* Loading state */
        .course-card {
            opacity: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category filter functionality
            const filterButtons = document.querySelectorAll(".category-tag");
            const cards = document.querySelectorAll(".course-card");

            filterButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    // Remove active class from all buttons
                    filterButtons.forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");

                    const category = btn.dataset.category;
                    
                    cards.forEach(card => {
                        if (category === "all" || card.dataset.category === category) {
                            card.style.display = "flex";
                            card.style.animation = "fadeInUp 0.6s ease forwards";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            });

            // Smooth scroll for buttons
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255,255,255,0.5);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                        left: ${e.offsetX}px;
                        top: ${e.offsetY}px;
                        width: 20px;
                        height: 20px;
                        margin-left: -10px;
                        margin-top: -10px;
                    `;
                    
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                    
                    // Your navigation logic here
                    console.log('Button clicked:', this.textContent);
                });
            });

            // Course card hover effects
            const courseCards = document.querySelectorAll('.course-card');
            
            courseCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.zIndex = '1';
                });
            });

            // Intersection Observer for animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            courseCards.forEach(card => observer.observe(card));
        });

        // Add ripple animation CSS
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
@endpush