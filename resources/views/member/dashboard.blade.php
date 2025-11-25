@extends('layouts.member')

@section('title', 'Dashboard')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --success-green: #10b981;
    --error-red: #ef4444;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.stat-icon.classes { background: var(--primary-brown); }
.stat-icon.bootcamps { background: var(--primary-gold); }
.stat-icon.enrolled { background: var(--success-green); }
.stat-icon.grades { background: var(--deep-brown); }

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 500;
}

.content-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.section-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--light-cream);
}

.section-header h3 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.25rem;
    font-weight: 600;
}

.section-content {
    padding: 1.5rem;
}

.class-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.class-item:hover {
    border-color: var(--primary-gold);
    background: #fafafa;
}

.class-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    background: var(--light-cream);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.class-details h4 {
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.class-details p {
    margin: 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.tutor-info {
    display: flex;
    align-items: center;
    margin-top: 0.5rem;
}

.tutor-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--primary-gold);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    margin-right: 0.5rem;
}

.grade-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 1rem;
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.grade-score {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--success-green);
    margin-left: auto;
}

.task-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.task-due {
    font-size: 0.875rem;
    color: var(--error-red);
    font-weight: 500;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.view-all-btn {
    background: var(--primary-brown);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .dashboard-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .section-content {
        padding: 1rem;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-1" style="color: var(--primary-brown);">Welcome back, {{ $member->name }}!</h1>
                    <p class="text-muted mb-0">Here's your learning progress overview</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">{{ now()->format('l, F d, Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon classes">
                <i class="bx bx-book"></i>
            </div>
            <div class="stat-number">{{ $totalClasses }}</div>
            <div class="stat-label">Available Classes</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bootcamps">
                <i class="bx bx-code-alt"></i>
            </div>
            <div class="stat-number">{{ $totalBootcamps }}</div>
            <div class="stat-label">Available Bootcamps</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon enrolled">
                <i class="bx bx-check-circle"></i>
            </div>
            <div class="stat-number">{{ $enrolledClassesCount + $enrolledBootcampsCount }}</div>
            <div class="stat-label">Total Enrollments</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon grades">
                <i class="bx bx-trophy"></i>
            </div>
            <div class="stat-number">{{ number_format($averageGrade, 1) }}</div>
            <div class="stat-label">Average Grade</div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Classes -->
        <div class="col-lg-6 mb-4">
            <div class="content-section">
                <div class="section-header">
                    <h3>My Recent Classes</h3>
                    <a href="{{ route('member.enrollments') }}" class="view-all-btn">View All</a>
                </div>
                <div class="section-content">
                    @if($recentClasses->count() > 0)
                        @foreach($recentClasses as $class)
                        <div class="class-item">
                            <div class="class-image">
                                @if($class->image)
                                    <img src="{{ asset($class->image) }}" alt="{{ $class->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                @else
                                    <i class="bx bx-book" style="font-size: 1.5rem; color: var(--primary-brown);"></i>
                                @endif
                            </div>
                            <div class="class-details">
                                <h4>{{ $class->title }}</h4>
                                <p>{{ Str::limit($class->description, 80) }}</p>
                                <div class="tutor-info">
                                    <div class="tutor-avatar">
                                        {{ strtoupper(substr($class->tutor->name ?? 'T', 0, 1)) }}
                                    </div>
                                    <span style="font-size: 0.875rem; color: var(--text-secondary);">{{ $class->tutor->name ?? 'Tutor' }}</span>
                                </div>
                                <div class="class-actions mt-2">
                                    <a href="{{ route('elearning.class', $class->id) }}" 
                                       class="btn btn-sm" 
                                       style="background: var(--primary-brown); color: white; border: none; padding: 0.375rem 0.75rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem;">
                                        <i class="bx bx-play-circle me-1"></i>Start Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="bx bx-book-bookmark"></i>
                            <p>No enrolled classes yet</p>
                            <a href="{{ route('learning') }}" class="view-all-btn">Browse Classes</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Grades -->
        <div class="col-lg-6 mb-4">
            <div class="content-section">
                <div class="section-header">
                    <h3>Recent Grades</h3>
                    <a href="{{ route('member.grades') }}" class="view-all-btn">View All</a>
                </div>
                <div class="section-content">
                    @if($memberGrades->count() > 0)
                        @foreach($memberGrades as $grade)
                        <div class="grade-item">
                            <div>
                                <h5 style="margin: 0 0 0.25rem 0;">{{ $grade->task->title ?? 'Task' }}</h5>
                                <p style="margin: 0; font-size: 0.875rem; color: var(--text-secondary);">{{ $grade->class->title ?? 'Class' }}</p>
                            </div>
                            <div class="grade-score">{{ $grade->score }}/100</div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="bx bx-trophy"></i>
                            <p>No grades yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Task Progress Overview -->
    <div class="content-section">
        <div class="section-header">
            <h3>Task Progress Overview</h3>
            <span class="badge bg-primary">{{ $taskProgressPercentage }}% Complete</span>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-md-8">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Overall Progress</span>
                            <span class="text-muted">{{ $completedTasks }}/{{ $allTasks }} tasks completed</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $taskProgressPercentage }}%; transition: width 0.6s ease;"
                                 aria-valuenow="{{ $taskProgressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Task Statistics -->
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-success">{{ $completedTasks }}</div>
                                <div class="small text-muted">Completed</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-warning">{{ $pendingTasks }}</div>
                                <div class="small text-muted">Pending Grade</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-info">{{ $notSubmittedTasks }}</div>
                                <div class="small text-muted">Not Submitted</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="h4 mb-1 text-primary">{{ $certificatesCount }}</div>
                                <div class="small text-muted">Certificates</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Circular Progress -->
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <svg width="120" height="120" class="circular-progress">
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                                <circle cx="60" cy="60" r="50" fill="none" stroke="var(--success-green)" stroke-width="8"
                                        stroke-dasharray="{{ 2 * 3.14159 * 50 }}" 
                                        stroke-dashoffset="{{ 2 * 3.14159 * 50 * (1 - $taskProgressPercentage / 100) }}"
                                        stroke-linecap="round" 
                                        style="transition: stroke-dashoffset 0.6s ease; transform: rotate(-90deg); transform-origin: center;"/>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                <div class="h3 mb-0 fw-bold text-success">{{ $taskProgressPercentage }}%</div>
                                <div class="small text-muted">Complete</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('member.tasks.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-task"></i> View All Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Tasks -->
    <div class="content-section">
        <div class="section-header">
            <h3>Upcoming Tasks</h3>
            <a href="{{ route('member.tasks.index') }}" class="view-all-btn">View All</a>
        </div>
        <div class="section-content">
            @if($upcomingTasks->count() > 0)
                <div class="row">
                    @foreach($upcomingTasks as $task)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="task-item">
                            <div>
                                <h5 style="margin: 0 0 0.25rem 0;">{{ $task->title }}</h5>
                                <p style="margin: 0; font-size: 0.875rem; color: var(--text-secondary);">{{ $task->class->title ?? 'Class' }}</p>
                                <div class="task-due">Due: {{ $task->due_date->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bx bx-task"></i>
                    <p>No upcoming tasks</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection