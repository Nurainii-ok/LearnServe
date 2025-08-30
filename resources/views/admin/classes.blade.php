@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
/* Dashboard-specific styles using logo color palette */
:root {
    --primary-gold: #ecac57;
    --primary-brown: #944e25;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --text-primary: #2c2c2c;
    --text-secondary: #666666;
    --background-light: #f8f8f8;
    --white: #ffffff;
    --success-green: #4a7c59;
    --info-blue: #5b7c8a;
    --alert-orange: #d97435;
    --border-color: #e0e0e0;
}

.dashboard-container {
    display: flex;
    gap: 24px;
    max-width: 1400px;
    margin: 0 auto;
    height: calc(100vh - 120px); /* Fixed height untuk container */
    overflow: hidden;
}

/* Left Section */
.left-section {
    flex: 2.5;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.filter-bar {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px; /* Dikurangi dari 24px */
    padding: 16px; /* Dikurangi dari 20px */
    background: var(--white);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    flex-shrink: 0;
}

.filter-bar label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem; /* Dikurangi dari 0.95rem */
    white-space: nowrap;
}

.filter-bar select {
    padding: 8px 12px; /* Dikurangi dari 10px 14px */
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--white);
    color: var(--text-primary);
    font-size: 0.85rem; /* Dikurangi dari 0.9rem */
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 120px; /* Dikurangi dari 140px */
}

.filter-bar select:hover {
    border-color: var(--primary-gold);
}

.filter-bar select:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
}

/* Courses List */
.courses-list {
    display: flex;
    flex-direction: column;
    gap: 12px; /* Dikurangi dari 20px */
    flex: 1;
    overflow-y: auto;
    padding-right: 8px;
}

.course-card {
    background: var(--white);
    padding: 16px; /* Dikurangi dari 24px */
    border-radius: 10px; /* Dikurangi dari 12px */
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}

.course-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: var(--primary-brown);
    transition: width 0.3s ease;
}

.course-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.course-card:hover::before {
    width: 6px;
}

.course-card.primary::before {
    background: var(--primary-brown);
}

.course-card.secondary::before {
    background: var(--primary-gold);
}

.course-card.accent::before {
    background: var(--alert-orange);
}

.course-card h3 {
    font-size: 1.1rem; /* Dikurangi dari 1.25rem */
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 8px 0; /* Dikurangi dari 12px */
    line-height: 1.3;
}

.course-card p {
    font-size: 0.85rem; /* Dikurangi dari 0.95rem */
    color: var(--text-secondary);
    margin: 0 0 10px 0; /* Dikurangi dari 16px */
    line-height: 1.4; /* Dikurangi dari 1.5 */
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Batasi ke 2 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-card small {
    font-size: 0.8rem; /* Dikurangi dari 0.85rem */
    color: var(--text-secondary);
}

.course-card .author {
    color: var(--primary-brown);
    font-weight: 600;
}

/* Right Section */
.right-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 16px; /* Dikurangi dari 24px */
    height: 100%;
}

.widget {
    background: var(--white);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
    flex-shrink: 0;
}

.widget-header {
    padding: 16px 16px 12px 16px; /* Dikurangi dari 20px 20px 16px 20px */
    border-bottom: 1px solid var(--border-color);
    background: var(--light-cream);
}

.widget-header h4 {
    font-size: 1rem; /* Dikurangi dari 1.1rem */
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.widget-body {
    padding: 16px; /* Dikurangi dari 20px */
}

/* Calendar Styles */
.calendar table {
    width: 100%;
    border-collapse: collapse;
}

.calendar th {
    padding: 6px 3px; /* Dikurangi dari 8px 4px */
    font-size: 0.75rem; /* Dikurangi dari 0.8rem */
    font-weight: 600;
    color: var(--text-secondary);
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.calendar td {
    padding: 6px 3px; /* Dikurangi dari 8px 4px */
    font-size: 0.8rem; /* Dikurangi dari 0.9rem */
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 4px; /* Dikurangi dari 6px */
    margin: 2px;
}

.calendar td:not(:empty):hover {
    background: var(--light-cream);
    color: var(--primary-brown);
}

.calendar td.active {
    background: var(--primary-brown);
    color: var(--white);
    font-weight: 600;
}

.calendar td.today {
    background: var(--primary-gold);
    color: var(--white);
    font-weight: 600;
}

/* Online Users */
.online-users ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.online-users li {
    display: flex;
    align-items: center;
    padding: 8px 0; /* Dikurangi dari 12px */
    border-bottom: 1px solid var(--border-color);
    transition: background 0.2s ease;
}

.online-users li:last-child {
    border-bottom: none;
}

.online-users li:hover {
    background: var(--light-cream);
    margin: 0 -16px; /* Disesuaikan dengan padding widget */
    padding: 8px 16px; /* Disesuaikan */
    border-radius: 8px;
}

.online-users img {
    width: 32px; /* Dikurangi dari 36px */
    height: 32px; /* Dikurangi dari 36px */
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px; /* Dikurangi dari 12px */
    border: 2px solid var(--border-color);
    background: var(--light-cream);
}

.online-users .user-name {
    flex: 1;
    font-size: 0.85rem; /* Dikurangi dari 0.9rem */
    font-weight: 500;
    color: var(--text-primary);
}

.online-users .status-dot {
    width: 8px; /* Dikurangi dari 10px */
    height: 8px; /* Dikurangi dari 10px */
    border-radius: 50%;
    background: var(--success-green);
    border: 2px solid var(--white);
    box-shadow: 0 0 4px rgba(74, 124, 89, 0.3);
}

/* Stats Cards (if needed) */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Dikurangi dari 200px */
    gap: 16px; /* Dikurangi dari 20px */
    margin-bottom: 16px; /* Dikurangi dari 24px */
}

.stat-card {
    background: var(--white);
    padding: 16px; /* Dikurangi dari 20px */
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    text-align: center;
}

.stat-card .stat-number {
    font-size: 1.75rem; /* Dikurangi dari 2rem */
    font-weight: 700;
    color: var(--primary-brown);
    margin-bottom: 6px; /* Dikurangi dari 8px */
}

.stat-card .stat-label {
    font-size: 0.85rem; /* Dikurangi dari 0.9rem */
    color: var(--text-secondary);
    font-weight: 500;
}

/* Quick Actions Button Styles */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 8px; /* Dikurangi dari 12px */
}

.quick-actions button {
    padding: 10px; /* Dikurangi dari 12px */
    border: none;
    border-radius: 6px; /* Dikurangi dari 8px */
    cursor: pointer;
    font-weight: 500;
    font-size: 0.85rem; /* Ditambahkan untuk konsistensi */
    transition: all 0.2s ease;
}

.quick-actions button:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .dashboard-container {
        flex-direction: column;
        gap: 16px; /* Dikurangi dari 20px */
        height: auto;
    }
    
    .filter-bar {
        flex-wrap: wrap;
        gap: 10px; /* Dikurangi dari 12px */
    }
    
    .filter-bar select {
        min-width: 100px; /* Dikurangi dari 120px */
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        gap: 12px; /* Dikurangi dari 16px */
    }
    
    .filter-bar {
        padding: 12px; /* Dikurangi dari 16px */
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-bar label {
        margin-bottom: 6px; /* Dikurangi dari 8px */
    }
    
    .filter-bar select {
        width: 100%;
        min-width: auto;
    }
    
    .course-card {
        padding: 14px; /* Dikurangi dari 20px */
    }
    
    .course-card h3 {
        font-size: 1rem; /* Dikurangi dari 1.1rem */
    }
    
    .widget-body {
        padding: 12px; /* Dikurangi dari 16px */
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); /* Dikurangi dari 150px */
        gap: 12px; /* Dikurangi dari 16px */
    }
}

@media (max-width: 480px) {
    .course-card {
        padding: 12px; /* Dikurangi dari 16px */
    }
    
    .widget-header {
        padding: 12px 12px 10px 12px; /* Dikurangi dari 16px 16px 12px 16px */
    }
    
    .widget-body {
        padding: 10px 12px 12px 12px; /* Dikurangi dari 12px 16px 16px 16px */
    }
    
    .online-users img {
        width: 28px; /* Dikurangi dari 32px */
        height: 28px; /* Dikurangi dari 32px */
    }
    
    .calendar th,
    .calendar td {
        padding: 4px 2px; /* Dikurangi dari 6px 2px */
        font-size: 0.75rem; /* Dikurangi dari 0.8rem */
    }
}

/* Scrollbar untuk courses list */
.courses-list::-webkit-scrollbar {
    width: 4px;
}

.courses-list::-webkit-scrollbar-track {
    background: var(--light-cream);
    border-radius: 2px;
}

.courses-list::-webkit-scrollbar-thumb {
    background: var(--primary-gold);
    border-radius: 2px;
}

.courses-list::-webkit-scrollbar-thumb:hover {
    background: var(--primary-brown);
}
</style>

<!-- Optional Stats Cards Section -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">24</div>
        <div class="stat-label">Active Courses</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">1,247</div>
        <div class="stat-label">Total Students</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">89</div>
        <div class="stat-label">Online Now</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">4.8</div>
        <div class="stat-label">Avg Rating</div>
    </div>
</div>

<div class="dashboard-container">
    <!-- Left Section -->
    <div class="left-section">
        <!-- Filter Bar -->
        <div class="filter-bar">
            <label for="filter">Filter by:</label>
            <select id="filter" name="filter">
                <option value="time">Time</option>
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="popular">Most Popular</option>
            </select>

            <select id="level" name="level">
                <option value="all">All Levels</option>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
            </select>

            <select id="category" name="category">
                <option value="all">All Categories</option>
                <option value="web-dev">Web Development</option>
                <option value="design">UI/UX Design</option>
                <option value="backend">Backend Development</option>
                <option value="mobile">Mobile Development</option>
            </select>
        </div>

        <!-- Courses List -->
        <div class="courses-list">
            <div class="course-card primary">
                <h3>Web Development Fundamentals</h3>
                <p>Master the core technologies of modern web development including HTML5, CSS3, and JavaScript ES6. Build responsive and interactive websites from scratch.</p>
                <small>By <span class="author">John Doe</span> • 4.8 ⭐ • 1,234 students</small>
            </div>

            <div class="course-card secondary">
                <h3>UI/UX Design Mastery</h3>
                <p>Learn user-centered design principles, prototyping, and modern design tools. Create beautiful and functional digital experiences that users love.</p>
                <small>By <span class="author">Jane Smith</span> • 4.9 ⭐ • 892 students</small>
            </div>

            <div class="course-card accent">
                <h3>Laravel Framework Complete Guide</h3>
                <p>Build robust web applications with Laravel. Learn MVC architecture, database relationships, authentication, and API development.</p>
                <small>By <span class="author">Michael Lee</span> • 4.7 ⭐ • 567 students</small>
            </div>

            <div class="course-card primary">
                <h3>React.js for Modern Web Apps</h3>
                <p>Create dynamic single-page applications with React.js. Learn components, hooks, state management, and modern development workflows.</p>
                <small>By <span class="author">Sarah Wilson</span> • 4.8 ⭐ • 1,089 students</small>
            </div>

            <div class="course-card secondary">
                <h3>Digital Marketing Strategy</h3>
                <p>Develop comprehensive digital marketing campaigns. Learn SEO, social media marketing, content strategy, and analytics.</p>
                <small>By <span class="author">David Chen</span> • 4.6 ⭐ • 756 students</small>
            </div>
        </div>
    </div>

    <!-- Right Section -->
    <div class="right-section">
        <!-- Calendar Widget -->
        <div class="widget">
            <div class="widget-header">
                <h4>📅 Calendar</h4>
            </div>
            <div class="widget-body">
                <div class="calendar">
                    <table>
                        <thead>
                            <tr>
                                <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td><td>1</td><td>2</td><td>3</td><td class="active">4</td><td>5</td><td>6</td>
                            </tr>
                            <tr>
                                <td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td>
                            </tr>
                            <tr>
                                <td>14</td><td>15</td><td>16</td><td>17</td><td class="today">18</td><td>19</td><td>20</td>
                            </tr>
                            <tr>
                                <td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td>
                            </tr>
                            <tr>
                                <td>28</td><td>29</td><td>30</td><td>31</td><td></td><td></td><td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Online Users Widget -->
        <div class="widget">
            <div class="widget-header">
                <h4>🟢 Online Users</h4>
            </div>
            <div class="widget-body">
                <div class="online-users">
                    <ul>
                        <li>
                            <img src="https://images.unsplash.com/photo-1494790108755-2616c56107b0?w=150" alt="Alice Profile">
                            <span class="user-name">Alice Johnson</span>
                            <span class="status-dot"></span>
                        </li>
                        <li>
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150" alt="Bob Profile">
                            <span class="user-name">Bob Martinez</span>
                            <span class="status-dot"></span>
                        </li>
                        <li>
                            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150" alt="Charlie Profile">
                            <span class="user-name">Charlie Brown</span>
                            <span class="status-dot"></span>
                        </li>
                        <li>
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150" alt="Diana Profile">
                            <span class="user-name">Diana Smith</span>
                            <span class="status-dot"></span>
                        </li>
                        <li>
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150" alt="Ethan Profile">
                            <span class="user-name">Ethan Wilson</span>
                            <span class="status-dot"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions Widget (Optional) -->
        <div class="widget">
            <div class="widget-header">
                <h4>⚡ Quick Actions</h4>
            </div>
            <div class="widget-body">
                <div class="quick-actions">
                    <button style="background: var(--primary-brown); color: white;">Add New Course</button>
                    <button style="background: var(--primary-gold); color: white;">Manage Students</button>
                    <button style="background: var(--success-green); color: white;">View Reports</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simple interactivity for dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterSelect = document.getElementById('filter');
    const levelSelect = document.getElementById('level');
    const categorySelect = document.getElementById('category');
    
    function handleFilterChange() {
        // Add your filter logic here
        console.log('Filter changed:', {
            filter: filterSelect.value,
            level: levelSelect.value,
            category: categorySelect.value
        });
    }
    
    filterSelect.addEventListener('change', handleFilterChange);
    levelSelect.addEventListener('change', handleFilterChange);
    categorySelect.addEventListener('change', handleFilterChange);
    
    // Calendar interactivity
    const calendarCells = document.querySelectorAll('.calendar td:not(:empty)');
    calendarCells.forEach(cell => {
        cell.addEventListener('click', function() {
            // Remove active class from all cells
            calendarCells.forEach(c => c.classList.remove('active'));
            // Add active class to clicked cell
            this.classList.add('active');
        });
    });
});
</script>

@endsection