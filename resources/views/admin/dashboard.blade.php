@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
.dashboard-content {
    padding: 0px;
    margin: 0;
}

/* ========== STAT CARDS ========== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all .3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-card.featured {
    background: linear-gradient(135deg, var(--primary-gold, #d4a457) 0%, #e59f4f 100%);
    color: #fff;
    border: none;
}

.stat-info h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.stat-info p {
    margin-top: .5rem;
    font-size: .875rem;
    opacity: .8;
}

.stat-icon {
    font-size: 2.5rem;
    opacity: .7;
}

/* ========== DASHBOARD GRID ========== */
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.dashboard-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: between;
    align-items: center;
}

.card-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.card-body {
    padding: 1.5rem;
}

/* ========== BUTTON ========== */
.btn-secondary {
    background: var(--primary-brown, #5c3d2e);
    color: #fff;
    padding: .5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: .875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
    transition: all .3s ease;
    cursor: pointer;
}

.btn-secondary:hover {
    background: var(--deep-brown, #3b2418);
}

/* ========== TABLE ========== */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    background: #f8fafc;
    padding: 1rem;
    text-align: left;
    font-size: .875rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.data-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

/* ========== USER INFO ========== */
.user-info {
    display: flex;
    align-items: center;
    gap: .75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-gold, #d4a457);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: .875rem;
}

/* ========== STATUS BADGE ========== */
.status-badge {
    padding: .25rem .75rem;
    border-radius: 20px;
    font-size: .75rem;
    font-weight: 500;
    color: #fff;
}

.status-active { background: #10b981; }
.status-completed { background: #3b82f6; }
.status-paused { background: #f59e0b; }
.status-dropped { background: #ef4444; }

/* ========== RESPONSIVE ========== */
@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card featured">
            <div class="stat-info">
                <h3>{{ $totalMembers }}</h3>
                <p>Total Members</p>
            </div>
            <div class="stat-icon">
                <i class="las la-users"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalClasses }}</h3>
                <p>Active Classes</p>
            </div>
            <div class="stat-icon">
                <i class="las la-graduation-cap"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalBootcamps }}</h3>
                <p>Active Bootcamps</p>
            </div>
            <div class="stat-icon">
                <i class="las la-rocket"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalEnrollments ?? 0 }}</h3>
                <p>Total Enrollments</p>
            </div>
            <div class="stat-icon">
                <i class="las la-user-check"></i>
            </div>
        </div>
    </div>

    <!-- Task Completion Overview -->
    <div class="dashboard-card mb-4">
        <div class="card-header">
            <h3>Task Completion Overview</h3>
            <span class="status-badge status-completed">{{ $taskCompletionRate }}% Complete</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Overall Task Completion</span>
                            <span class="text-muted">{{ $completedTasks }}/{{ $totalTasks }} tasks completed</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $taskCompletionRate }}%; transition: width 0.6s ease;"
                                 aria-valuenow="{{ $taskCompletionRate }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Task Statistics Grid -->
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div class="stat-info">
                                    <h3 class="text-primary">{{ $totalTasks }}</h3>
                                    <p>Total Tasks</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div class="stat-info">
                                    <h3 class="text-success">{{ $completedTasks }}</h3>
                                    <p>Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div class="stat-info">
                                    <h3 class="text-warning">{{ $pendingTasks }}</h3>
                                    <p>Pending Grade</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div class="stat-info">
                                    <h3 class="text-info">{{ $totalCertificates }}</h3>
                                    <p>Certificates Issued</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Certificate Breakdown -->
                    <div class="text-center">
                        <h5 class="mb-3">Certificates by Type</h5>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Task Certificates</span>
                                <span class="badge bg-primary">{{ $taskCertificates }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: {{ $totalCertificates > 0 ? ($taskCertificates / $totalCertificates) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Class Certificates</span>
                                <span class="badge bg-info">{{ $classCertificates }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: {{ $totalCertificates > 0 ? ($classCertificates / $totalCertificates) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Bootcamp Certificates</span>
                                <span class="badge bg-success">{{ $bootcampCertificates }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $totalCertificates > 0 ? ($bootcampCertificates / $totalCertificates) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('admin.certificates') }}" class="btn-secondary btn-sm">
                            <i class="las la-certificate"></i> View All Certificates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Recent Members Table -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Members</h3>
                <a href="{{ route('admin.members') }}" class="btn-secondary">
                    See all <i class="las la-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentMembers->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMembers as $member)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium">{{ $member->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="status-badge status-active">Active</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500">No recent members</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Enrollments -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Enrollments</h3>
            </div>
            <div class="card-body">
                @if($recentEnrollments->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentEnrollments->take(5) as $enrollment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium">{{ $enrollment->user->name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $enrollment->class->title ?? $enrollment->bootcamp->title }}
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $enrollment->created_at->format('M d') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500">No recent enrollments</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection