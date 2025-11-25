@extends('layouts.tutor')

@section('title', 'Tutor Dashboard')

@section('styles')
<style>
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
        --border-color: #e5e5e5;
    }

    /* Main Container */
    .dashboard-container {
        background: var(--background-light);
        min-height: 100vh;
        padding: 2rem 1rem;
    }

    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .dashboard-header p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.75rem;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 12px 12px 0 0;
    }

    .stat-card.brown::before {
        background: var(--primary-brown);
    }

    .stat-card.gold::before {
        background: var(--primary-gold);
    }

    .stat-card.info::before {
        background: var(--info-blue);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-info {
        flex: 1;
    }

    .stat-info h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: var(--text-primary);
        line-height: 1;
    }

    .stat-info p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }

    .stat-card.brown .stat-icon {
        background: rgba(148, 78, 37, 0.1);
        color: var(--primary-brown);
    }

    .stat-card.gold .stat-icon {
        background: rgba(236, 172, 87, 0.15);
        color: var(--primary-gold);
    }

    .stat-card.info .stat-icon {
        background: rgba(91, 124, 138, 0.1);
        color: var(--info-blue);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Card Styles */
    .card {
        background: var(--white);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white);
    }

    .card-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .card-body {
        padding: 0;
    }

    .btn-manage {
        background: var(--primary-brown);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-manage:hover {
        background: var(--deep-brown);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(148, 78, 37, 0.3);
    }

    /* Class Item */
    .class-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s;
    }

    .class-item:last-child {
        border-bottom: none;
    }

    .class-item:hover {
        background: var(--background-light);
    }

    .class-time {
        font-weight: 700;
        color: var(--primary-brown);
        font-size: 1rem;
        min-width: 60px;
        text-align: center;
        padding: 0.5rem;
        background: rgba(148, 78, 37, 0.05);
        border-radius: 8px;
    }

    .class-details {
        flex: 1;
    }

    .class-name {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-primary);
    }

    .class-date {
        color: var(--text-secondary);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .class-badge {
        background: var(--primary-gold);
        color: white;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Student Item */
    .student-item {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s;
    }

    .student-item:last-child {
        border-bottom: none;
    }

    .student-item:hover {
        background: var(--background-light);
    }

    .student-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-gold), var(--primary-brown));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(236, 172, 87, 0.3);
    }

    .student-info {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-primary);
        margin-bottom: 0.125rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .student-email {
        color: var(--text-secondary);
        font-size: 0.75rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        color: var(--primary-brown);
    }

    .empty-state p {
        margin: 0;
        font-size: 0.95rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1.25rem;
        }

        .stat-info h3 {
            font-size: 1.75rem;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            font-size: 1.5rem;
        }

        .card-header {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .class-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .class-time {
            align-self: flex-start;
        }

        .class-badge {
            align-self: flex-start;
        }
    }

    @media (max-width: 480px) {
        .class-item,
        .student-item {
            padding: 1rem;
        }

        .card-header {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Welcome back! Here's an overview of your teaching activities.</p>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card brown">
            <div class="stat-info">
                <h3>{{ $totalStudents }}</h3>
                <p>Total Students</p>
            </div>
            <div class="stat-icon">
                <i class="las la-user-graduate"></i>
            </div>
        </div>

        <div class="stat-card gold">
            <div class="stat-info">
                <h3>{{ $totalClasses }}</h3>
                <p>Active Classes</p>
            </div>
            <div class="stat-icon">
                <i class="las la-chalkboard-teacher"></i>
            </div>
        </div>

        <div class="stat-card info">
            <div class="stat-info">
                <h3>Rp{{ number_format($monthlyEarnings, 0, ',', '.') }}</h3>
                <p>Monthly Earnings</p>
            </div>
            <div class="stat-icon">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Upcoming Classes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upcoming Classes</h3>
                <a href="{{ route('tutor.classes') }}" class="btn-manage">
                    <i class="las la-cog"></i>
                    Manage
                </a>
            </div>
            <div class="card-body">
                @forelse($recentClasses as $class)
                    <div class="class-item">
                        <div class="class-time">
                            @if(is_string($class['next_session']) && $class['next_session'] !== 'Self-paced learning')
                                {{ \Carbon\Carbon::parse($class['next_session'])->format('H:i') }}
                            @else
                                {{ now()->addHours(rand(1, 12))->format('H:i') }}
                            @endif
                        </div>

                        <div class="class-details">
                            <h5 class="class-name">{{ $class['name'] }}</h5>
                            <div class="class-date">
                                <i class="las la-calendar" style="font-size: 0.9rem;"></i>
                                @if(is_string($class['next_session']) && $class['next_session'] !== 'Self-paced learning')
                                    {{ \Carbon\Carbon::parse($class['next_session'])->format('M d, Y') }}
                                @else
                                    {{ now()->addDays(rand(1, 7))->format('M d, Y') }}
                                @endif
                            </div>
                        </div>

                        <div class="class-badge">
                            <i class="las la-users"></i>
                            {{ $class['students'] }} students
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="las la-calendar-times"></i>
                        <p>No upcoming classes scheduled</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Students -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Students</h3>
            </div>
            <div class="card-body">
                @forelse($recentStudents as $student)
                    <div class="student-item">
                        <div class="student-avatar">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                        <div class="student-info">
                            <div class="student-name">{{ $student->name }}</div>
                            <div class="student-email">{{ $student->email }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="las la-user-graduate"></i>
                        <p>No students enrolled yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Smooth animations for stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Button hover effects
    const buttons = document.querySelectorAll('.btn-manage');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection