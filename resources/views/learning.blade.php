<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratusan Skill Impian Kini Dalam Genggamanmu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInUp 0.8s ease-out;
        }

        .header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.2rem;
            color: #4a5568;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .categories {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 40px;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .category-tag {
            background: linear-gradient(135deg, #00d4aa, #00a8cc);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
        }

        .category-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 170, 0.4);
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .course-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            cursor: pointer;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .course-image {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .course-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1));
            z-index: 1;
        }

        .course-image.copywriting {
            background: linear-gradient(135deg, #84fab0, #8fd3f4);
        }

        .course-image.seo {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }

        .course-image.analytics {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .course-image.marketing {
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
        }

        .course-image.funnel {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
        }

        .instructor {
            position: absolute;
            bottom: 16px;
            right: 16px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #333;
            z-index: 2;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .course-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .course-content {
            padding: 24px;
        }

        .course-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .course-instructor {
            color: #4a5568;
            font-size: 0.9rem;
            margin-bottom: 16px;
        }

        .course-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #718096;
            font-size: 0.9rem;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #f6ad55;
        }

        .actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-top: 40px;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(251, 191, 36, 0.5);
        }

        .btn-secondary {
            background: transparent;
            color: #00d4aa;
            border: 2px solid #00d4aa;
        }

        .btn-secondary:hover {
            background: #00d4aa;
            color: white;
            transform: translateY(-2px);
        }

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
            animation: fadeInUp 0.8s ease-out calc(0.6s + var(--delay, 0s)) both;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-circle:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .courses-grid {
                grid-template-columns: 1fr;
            }

            .categories {
                flex-direction: column;
                align-items: center;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Ratusan Skill Impian Kini Dalam Genggamanmu</h1>
            <p>Lihat contoh beberapa materi terpopuler rancangan experts berikut. Materi baru setiap bulan tanpa tambahan biaya.</p>
        </div>

        <div class="categories">
            <button class="category-tag">Digital Marketing</button>
            <button class="category-tag">Data Science & Data Analysis</button>
            <button class="category-tag">Microsoft Excel, Word and PowerPoint</button>
            <button class="category-tag">UI-UX Research and Design</button>
            <button class="category-tag">Product and Project</button>
        </div>

        <div class="courses-grid">
            <div class="course-card" style="--delay: 0s">
                <div class="course-image copywriting">
                    <div class="course-badge">COPYWRITING SERIES</div>
                    <div class="instructor">VG</div>
                </div>
                <div class="course-content">
                    <h3 class="course-title">Copywriting Introduction</h3>
                    <p class="course-instructor">VERONICA G.<br>COPYWRITER<br>SATU Dental Group</p>
                    <div class="course-stats">
                        <div class="stat">📹 5 Video</div>
                        <div class="stat">👥 31.696</div>
                        <div class="rating">⭐ 4,7/5</div>
                    </div>
                </div>
            </div>

            <div class="course-card" style="--delay: 0.1s">
                <div class="course-image seo">
                    <div class="course-badge">SEARCH ENGINE OPTIMIZATION SERIES</div>
                    <div class="instructor">AP</div>
                </div>
                <div class="course-content">
                    <h3 class="course-title">SEO Fundamentals</h3>
                    <p class="course-instructor">ANTONIUS PUTU<br>SEO & ASO MANAGER<br>Jack and Transform</p>
                    <div class="course-stats">
                        <div class="stat">📹 3 Video</div>
                        <div class="stat">👥 10.979</div>
                        <div class="rating">⭐ 4,67/5</div>
                    </div>
                </div>
            </div>

            <div class="course-card" style="--delay: 0.2s">
                <div class="course-image analytics">
                    <div class="course-badge">GOOGLE ANALYTICS</div>
                    <div class="instructor">AP</div>
                </div>
                <div class="course-content">
                    <h3 class="course-title">Introduction to Google Analytics</h3>
                    <p class="course-instructor">ANTONIUS PUTU<br>SEO & ASO MANAGER<br>Jack and Transform</p>
                    <div class="course-stats">
                        <div class="stat">📹 4 Video</div>
                        <div class="stat">👥 1.782</div>
                        <div class="rating">⭐ 4,63/5</div>
                    </div>
                </div>
            </div>

            <div class="course-card" style="--delay: 0.3s">
                <div class="course-image marketing">
                    <div class="course-badge">MARKETING MANAGEMENT SERIES</div>
                    <div class="instructor">RD</div>
                </div>
                <div class="course-content">
                    <h3 class="course-title">Marketing Introduction</h3>
                    <p class="course-instructor">RYAN DWANA<br>BUSINESS DIRECTOR<br>Initiative • Global Media Agency</p>
                    <div class="course-stats">
                        <div class="stat">📹 5 Video</div>
                        <div class="stat">👥 60.938</div>
                        <div class="rating">⭐ 4,67/5</div>
                    </div>
                </div>
            </div>

            <div class="course-card" style="--delay: 0.4s">
                <div class="course-image funnel">
                    <div class="course-badge">GOOGLE ADS SERIES</div>
                    <div class="instructor">YM</div>
                </div>
                <div class="course-content">
                    <h3 class="course-title">Marketing Funnel</h3>
                    <p class="course-instructor">YOSANATAN. M<br>PERFORMANCE MARKETING<br>StockBit BliBit</p>
                    <div class="course-stats">
                        <div class="stat">📹 3 Video</div>
                        <div class="stat">👥 3.776</div>
                        <div class="rating">⭐ 4,55/5</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="#" class="btn btn-primary">Mulai Berlangganan</a>
            <a href="#" class="btn btn-secondary">Lihat Semua Materi</a>
        </div>
    </div>

    <script>
        // Add interactive hover effects
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Category filter functionality
        document.querySelectorAll('.category-tag').forEach(tag => {
            tag.addEventListener('click', function() {
                // Remove active class from all tags
                document.querySelectorAll('.category-tag').forEach(t => 
                    t.classList.remove('active'));
                
                // Add active class to clicked tag
                this.classList.add('active');
                
                // Add ripple effect
                const ripple = document.createElement('span');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    left: ${event.offsetX - 10}px;
                    top: ${event.offsetY - 10}px;
                    width: 20px;
                    height: 20px;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            .category-tag.active {
                background: linear-gradient(135deg, #667eea, #764ba2);
                transform: scale(1.05);
            }
        `;
        document.head.appendChild(style);

        // Smooth scroll and entrance animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.course-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>