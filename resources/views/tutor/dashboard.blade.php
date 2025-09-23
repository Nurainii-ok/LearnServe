@extends('layouts.tutor')

@section('title', 'Tutor Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
    --light-gray: #e5e5e5;
    --border-color: #e0e0e0;
}

.dashboard-content { 
    padding: 0; 
    margin: 0; 
    padding-top: 1rem; 
    background: var(--background-light);
    min-height: calc(100vh - 120px);
}

.stats-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
    gap: 1.5rem; 
    margin-bottom: 2rem; 
}

.stat-card { 
    background: var(--white); 
    border-radius: 12px; 
    padding: 1.5rem; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.08); 
    border: 1px solid var(--border-color); 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    transition: all 0.3s ease; 
    position: relative; 
}

.stat-card::before { 
    content: ''; 
    position: absolute; 
    top: 0; 
    left: 0; 
    right: 0; 
    height: 4px; 
    background: var(--primary-brown); 
    border-radius: 12px 12px 0 0;
}

.stat-card:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 8px 25px rgba(0,0,0,0.15); 
}

.stat-card.gold::before { background: var(--primary-gold); }
.stat-card.success::before { background: var(--success-green); }
.stat-card.info::before { background: var(--info-blue); }

.stat-info h3 { 
    font-size: 2rem; 
    font-weight: 700; 
    margin: 0; 
    color: var(--text-primary); 
}

.stat-info p { 
    margin: 0.5rem 0 0 0; 
    font-size: 0.875rem; 
    color: var(--text-secondary); 
    font-weight: 500; 
}

.stat-icon { 
    width: 60px; 
    height: 60px; 
    border-radius: 12px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 1.75rem; 
    background: var(--light-cream); 
    color: var(--primary-brown); 
}

.card {
    background: var(--white);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--white);
}

.card-body {
    padding: 1rem;
}

.btn-action:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalStudents }}</h3>
                <p>Total Students</p>
            </div>
            <div class="stat-icon"><i class="las la-user-graduate"></i></div>
        </div>
        <div class="stat-card gold">
            <div class="stat-info">
                <h3>{{ $totalClasses }}</h3>
                <p>Active Classes</p>
            </div>
            <div class="stat-icon"><i class="las la-chalkboard-teacher"></i></div>
        </div>
        <div class="stat-card success">
            <div class="stat-info">
                <h3>{{ $totalHours }}</h3>
                <p>Teaching Hours</p>
            </div>
            <div class="stat-icon"><i class="las la-clock"></i></div>
        </div>
        <div class="stat-card info">
            <div class="stat-info">
                <h3>Rp{{ number_format($monthlyEarnings, 0, ',', '.') }}</h3>
                <p>Monthly Earnings</p>
            </div>
            <div class="stat-icon"><i class="las la-wallet"></i></div>
        </div>
    </div>
    
    <!-- Simple layout for classes and students -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600;">Upcoming Classes</h3>
                <a href="{{ route('tutor.classes') }}" style="background: var(--primary-brown); color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.875rem;">Manage</a>
            </div>
            <div>
                @forelse($recentClasses as $class)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6;">
                    <div style="font-weight: 600; color: var(--primary-brown);">
                        @if(is_string($class['next_session']) && $class['next_session'] !== 'Self-paced learning')
                            {{ \Carbon\Carbon::parse($class['next_session'])->format('H:i') }}
                        @else
                            {{ now()->addHours(rand(1, 12))->format('H:i') }}
                        @endif
                    </div>
                    <div style="flex: 1; margin-left: 1rem;">
                        <h5 style="margin: 0; font-weight: 600;">{{ $class['name'] }}</h5>
                        <small style="color: #666;">
                            @if(is_string($class['next_session']) && $class['next_session'] !== 'Self-paced learning')
                                {{ \Carbon\Carbon::parse($class['next_session'])->format('M d, Y') }}
                            @else
                                {{ now()->addDays(rand(1, 7))->format('M d, Y') }}
                            @endif
                        </small>
                    </div>
                    <div style="background: var(--primary-gold); color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.8rem;">{{ $class['students'] }} students</div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem; color: #666;">No upcoming classes</div>
                @endforelse
            </div>
        </div>
        
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600;">Recent Students</h3>
            </div>
            <div>
                @forelse($recentStudents as $student)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-gold); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                        <div>
                            <div style="font-weight: 500;">{{ $student->name }}</div>
                            <small style="color: #666;">{{ $student->email }}</small>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem; color: #666;">No students yet</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions" style="margin-top: 2rem;">
        <div class="card">
            <div class="card-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; padding: 1rem;">
                    <button onclick="window.location.href='{{ route('tutor.classes') }}'" class="btn-action" style="
                        background: var(--primary-brown);
                        color: white;
                        padding: 1rem;
                        border: none;
                        border-radius: 12px;
                        cursor: pointer;
                        transition: all 0.3s;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <span class="las la-plus-circle"></span>
                        Create New Class
                    </button>
                    
                    <button onclick="window.location.href='{{ route('tutor.tasks') }}'" class="btn-action" style="
                        background: var(--primary-gold);
                        color: white;
                        padding: 1rem;
                        border: none;
                        border-radius: 12px;
                        cursor: pointer;
                        transition: all 0.3s;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <span class="las la-tasks"></span>
                        Assign Tasks
                    </button>
                    
                    <button onclick="alert('Grade management coming soon!')" class="btn-action" style="
                        background: var(--success-green);
                        color: white;
                        padding: 1rem;
                        border: none;
                        border-radius: 12px;
                        cursor: pointer;
                        transition: all 0.3s;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <span class="las la-star"></span>
                        Grade Students
                    </button>
                    
                    <button onclick="window.location.href='{{ route('tutor.account') }}'" class="btn-action" style="
                        background: var(--info-blue);
                        color: white;
                        padding: 1rem;
                        border: none;
                        border-radius: 12px;
                        cursor: pointer;
                        transition: all 0.3s;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <span class="las la-user-edit"></span>
                        Update Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Overview -->
    <div class="performance-overview" style="margin-top: 2rem;">
        <div class="card">
            <div class="card-header">
                <h2>This Month's Performance</h2>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; padding: 1rem;">
                    <div style="text-align: center; padding: 1rem; background: var(--light-cream); border-radius: 12px;">
                        <div style="font-size: 2rem; color: var(--primary-brown); margin-bottom: 0.5rem;">
                            <span class="las la-star"></span>
                        </div>
                        <h3 style="margin: 0; color: var(--text-primary);">4.8/5.0</h3>
                        <small style="color: var(--text-secondary);">Average Rating</small>
                    </div>
                    
                    <div style="text-align: center; padding: 1rem; background: var(--light-cream); border-radius: 12px;">
                        <div style="font-size: 2rem; color: var(--success-green); margin-bottom: 0.5rem;">
                            <span class="las la-check-circle"></span>
                        </div>
                        <h3 style="margin: 0; color: var(--text-primary);">95%</h3>
                        <small style="color: var(--text-secondary);">Completion Rate</small>
                    </div>
                    
                    <div style="text-align: center; padding: 1rem; background: var(--light-cream); border-radius: 12px;">
                        <div style="font-size: 2rem; color: var(--primary-gold); margin-bottom: 0.5rem;">
                            <span class="las la-trophy"></span>
                        </div>
                        <h3 style="margin: 0; color: var(--text-primary);">Top 10%</h3>
                        <small style="color: var(--text-secondary);">Instructor Ranking</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Dashboard interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to action buttons
    const actionButtons = document.querySelectorAll('.btn-action');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Add animation to schedule items
    const scheduleItems = document.querySelectorAll('.schedule-item');
    scheduleItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 100);
    });
});
</script>
@endsection
