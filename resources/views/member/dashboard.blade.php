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
    --warning-orange: #f59e0b;
    --info-blue: #3b82f6;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --border-color: #e5e7eb;
    --bg-light: #f9fafb;
}

/* Page Container */
.dashboard-container {
    padding: 2rem 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}

.stat-card {
    background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
    border-radius: 16px;
    padding: 1.75rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-brown), var(--primary-gold));
}

.stat-card:hover {
    transform: translateY(-4px);
}

.stat-content {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
}

.stat-icon-wrapper {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    flex-shrink: 0;
}

.stat-icon-wrapper.classes { 
    background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
}
.stat-icon-wrapper.bootcamps { 
    background: linear-gradient(135deg, var(--primary-gold), var(--soft-gold));
}
.stat-icon-wrapper.enrolled { 
    background: linear-gradient(135deg, var(--success-green), #059669);
}

.stat-info {
    flex: 1;
}

.stat-number {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.9375rem;
    font-weight: 500;
}

/* Two Column Layout */
.two-column-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    margin-bottom: 2rem;
    padding-top: 50px;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-header-custom {
    padding: 1.5rem 1.75rem;
    background: linear-gradient(135deg, var(--light-cream) 0%, #ffffff 100%);
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.card-header-custom h3 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.25rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-header-custom h3 i {
    font-size: 1.5rem;
}

.card-body-custom {
    padding: 0;
    flex: 1;
    overflow: auto;
}

/* Modern Table Styles */
.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table thead th {
    background: var(--bg-light);
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1.5rem;
    text-align: left;
    border-bottom: 2px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 10;
}

.modern-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.modern-table tbody tr:hover {
    background: var(--bg-light);
}

.modern-table tbody tr:last-child {
    border-bottom: none;
}

.modern-table tbody td {
    padding: 1.25rem 1.5rem;
    color: var(--text-secondary);
    font-size: 0.9375rem;
    vertical-align: middle;
}

/* Class Table Specific */
.class-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.class-thumbnail {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: var(--light-cream);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.class-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.class-thumbnail i {
    font-size: 1.5rem;
    color: var(--primary-brown);
}

.class-details-table h4 {
    margin: 0 0 0.25rem 0;
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--text-primary);
}

.class-details-table p {
    margin: 0;
    font-size: 0.8125rem;
    color: var(--text-secondary);
}

.tutor-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    background: var(--bg-light);
    border-radius: 20px;
    font-size: 0.8125rem;
    color: var(--text-secondary);
}

.tutor-avatar-small {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--primary-gold);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6875rem;
    font-weight: 600;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
    color: white;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.8125rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: linear-gradient(135deg, var(--deep-brown), var(--primary-brown));
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(148, 78, 37, 0.3);
}

/* Task Table Specific */
.task-priority {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.task-priority.high {
    background: #fee2e2;
    color: #991b1b;
}

.task-priority.medium {
    background: #fef3c7;
    color: #92400e;
}

.task-priority.low {
    background: #d1fae5;
    color: #065f46;
}

.task-due-date {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.task-due-date .date {
    font-weight: 600;
    color: var(--text-primary);
}

.task-due-date .time {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.task-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 500;
}

.task-status.overdue {
    background: #fef2f2;
    color: #991b1b;
}

.task-status.pending {
    background: #eff6ff;
    color: #1e40af;
}

/* View All Button */
.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: white;
    color: var(--primary-brown);
    border: 1px solid var(--primary-brown);
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.view-all-btn:hover {
    background: var(--primary-brown);
    color: white;
    transform: translateY(-1px);
}

/* Progress Section */
.progress-section {
    padding: 2rem 1.75rem;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.progress-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, var(--success-green), #059669);
    color: white;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9375rem;
}

.progress-bar-container {
    background: var(--bg-light);
    height: 14px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--success-green), #059669);
    border-radius: 10px;
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-top: 2rem;
}

.progress-stat-item {
    text-align: center;
    padding: 1.25rem;
    background: var(--bg-light);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.progress-stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.375rem;
}

.progress-stat-number.success { color: var(--success-green); }
.progress-stat-number.warning { color: var(--warning-orange); }
.progress-stat-number.info { color: var(--info-blue); }
.progress-stat-number.primary { color: var(--primary-brown); }

.progress-stat-label {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--text-secondary);
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: var(--bg-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
}

.empty-state-icon i {
    font-size: 2.5rem;
    color: #9ca3af;
}

.empty-state p {
    margin: 0 0 1rem 0;
    font-size: 1rem;
}

/* Responsive */
@media (max-width: 1200px) {
    .two-column-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 1.5rem 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1.25rem;
    }

    .stat-number {
        font-size: 1.75rem;
    }

    .card-header-custom {
        padding: 1.25rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .modern-table {
        font-size: 0.875rem;
    }

    .modern-table thead th,
    .modern-table tbody td {
        padding: 0.875rem 1rem;
    }

    .class-info {
        flex-direction: column;
        align-items: flex-start;
    }

    .progress-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .stat-content {
        gap: 1rem;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        font-size: 1.5rem;
    }

    /* Make tables scrollable on mobile */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .modern-table {
        min-width: 600px;
    }
}
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Statistics Cards -->
    <!--<div class="stats-grid">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-icon-wrapper classes">
                    <i class="bx bx-book"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalClasses }}</div>
                    <div class="stat-label">Available Classes</div>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-icon-wrapper bootcamps">
                    <i class="bx bx-code-alt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalBootcamps }}</div>
                    <div class="stat-label">Available Bootcamps</div>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-icon-wrapper enrolled">
                    <i class="bx bx-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $enrolledClassesCount + $enrolledBootcampsCount }}</div>
                    <div class="stat-label">Total Enrollments</div>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Two Column Layout: Task Progress & Recent Classes -->
    <div class="two-column-grid">
        <!-- Task Progress Overview -->
        <div class="content-card">
            <div class="card-header-custom">
                <h3>
                    <i class="bx bx-task"></i>
                    Task Progress
                </h3>
                <div class="progress-badge">
                    <i class="bx bx-check-circle"></i>
                    {{ $taskProgressPercentage }}%
                </div>
            </div>
            <div class="progress-section">
                <div class="progress-header">
                    <span class="fw-semibold" style="color: var(--text-primary);">Overall Progress</span>
                    <span style="color: var(--text-secondary); font-size: 0.9375rem;">{{ $completedTasks }}/{{ $allTasks }}</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: {{ $taskProgressPercentage }}%;"></div>
                </div>
                
                <!--<div class="progress-stats">
                    <div class="progress-stat-item">
                        <div class="progress-stat-number success">{{ $completedTasks }}</div>
                        <div class="progress-stat-label">Completed</div>
                    </div>
                    <div class="progress-stat-item">
                        <div class="progress-stat-number warning">{{ $pendingTasks }}</div>
                        <div class="progress-stat-label">Pending Grade</div>
                    </div>
                    <div class="progress-stat-item">
                        <div class="progress-stat-number info">{{ $notSubmittedTasks }}</div>
                        <div class="progress-stat-label">Not Submitted</div>
                    </div>
                    <div class="progress-stat-item">
                        <div class="progress-stat-number primary">{{ $certificatesCount }}</div>
                        <div class="progress-stat-label">Certificates</div>
                    </div>
                </div>-->
            </div>
        </div>

        <!-- My Recent Classes -->
        <div class="content-card">
            <div class="card-header-custom">
                <h3>
                    <i class="bx bx-book-bookmark"></i>
                    My Recent Classes
                </h3>
                <a href="{{ route('member.enrollments') }}" class="view-all-btn">
                    View All <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
            <div class="card-body-custom">
                @if($recentClasses->count() > 0)
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Tutor</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentClasses as $class)
                                <tr>
                                    <td>
                                        <div class="class-info">
                                            <div class="class-thumbnail">
                                                @if($class->image)
                                                    <img src="{{ asset($class->image) }}" alt="{{ $class->title }}">
                                                @else
                                                    <i class="bx bx-book"></i>
                                                @endif
                                            </div>
                                            <!--<div class="class-details-table">
                                                <h4>{{ $class->title }}</h4>
                                                <p>{{ Str::limit($class->description, 60) }}</p>
                                            </div>-->
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tutor-badge">
                                            <div class="tutor-avatar-small">
                                                {{ strtoupper(substr($class->tutor->name ?? 'T', 0, 1)) }}
                                            </div>
                                            <span>{{ $class->tutor->name ?? 'Tutor' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('elearning.class', $class->id) }}" class="action-btn">
                                            <i class="bx bx-play-circle"></i> Start
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bx bx-book-bookmark"></i>
                        </div>
                        <p>No enrolled classes yet</p>
                        <a href="{{ route('learning') }}" class="action-btn">
                            <i class="bx bx-search"></i> Browse Classes
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Tasks -->
    <div class="content-card">
        <div class="card-header-custom">
            <h3>
                <i class="bx bx-calendar-check"></i>
                Upcoming Tasks
            </h3>
            <a href="{{ route('member.tasks.index') }}" class="view-all-btn">
                View All <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>
        <div class="card-body-custom">
            @if($upcomingTasks->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Class</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingTasks as $task)
                            <tr>
                                <td>
                                    <h4 style="margin: 0; font-size: 0.9375rem; font-weight: 600; color: var(--text-primary);">
                                        {{ $task->title }}
                                    </h4>
                                </td>
                                <td>
                                    <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                        {{ $task->class->title ?? 'Class' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="task-priority {{ $task->priority ?? 'medium' }}">
                                        {{ ucfirst($task->priority ?? 'Medium') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="task-due-date">
                                        <span class="date">{{ $task->due_date->format('M d, Y') }}</span>
                                        <span class="time">{{ $task->due_date->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($task->is_overdue)
                                        <span class="task-status overdue">
                                            <i class="bx bx-error-circle"></i> Overdue
                                        </span>
                                    @else
                                        <span class="task-status pending">
                                            <i class="bx bx-time-five"></i> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bx bx-task"></i>
                    </div>
                    <p>No upcoming tasks</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection