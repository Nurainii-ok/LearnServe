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
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--light-cream, #f5efe7);
    color: var(--primary-brown, #5c3d2e);
    font-size: 1.75rem;
}

.stat-card.featured .stat-icon {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

/* ========== GRID LAYOUT ========== */
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

/* ========== CARD HEADER ========== */
.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #fafafa;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary, #1f2937);
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

/* ========== TUTOR LIST ========== */
.tutor-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.tutor-contact {
    display: flex;
    gap: .5rem;
}

.contact-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: #f3f4f6;
    color: #6b7280;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.contact-btn:hover {
    background: var(--primary-brown, #5c3d2e);
    color: #fff;
}

/* ========== EMPTY STATE ========== */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    opacity: .5;
    margin-bottom: 1rem;
}

/* ========== BADGE TYPE ========== */
.badge {
    padding: .25rem .5rem;
    border-radius: 4px;
    font-size: .75rem;
    font-weight: 500;
}

.badge-info { background: #17a2b8; color: #fff; }
.badge-primary { background: #944e25; color: #fff; }

/* ========== RESPONSIVE FIXES ========== */
@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
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
        
        <!--<div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalTutors }}</h3>
                <p>Total Tutors</p>
            </div>
            <div class="stat-icon">
                <i class="las la-chalkboard-teacher"></i>
            </div>
        </div>-->
        
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
        
        <!--<div class="stat-card">
            <div class="stat-info">
                <h3>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p>Monthly Revenue</p>
            </div>
            <div class="stat-icon">
                <i class="las la-chart-line"></i>
            </div>
        </div>-->
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
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium">{{ $member->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="status-badge">Active</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="las la-users"></i>
                        <h4>No members found</h4>
                        <p>No members have registered yet.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Tutors -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Tutors</h3>
                <a href="{{ route('admin.tutors') }}" class="btn-secondary">
                    See all <i class="las la-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentTutors->count() > 0)
                    @foreach($recentTutors as $tutor)
                    <div class="tutor-item">
                        <div class="user-info">
                            <div class="user-avatar" style="background: var(--primary-gold);">
                                {{ strtoupper(substr($tutor->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium">{{ $tutor->name }}</div>
                                <div class="text-sm text-gray-500">{{ $tutor->email }}</div>
                            </div>
                        </div>
                        <div class="tutor-contact">
                            <a href="#" class="contact-btn" title="Send Email">
                                <i class="las la-envelope"></i>
                            </a>
                            <a href="#" class="contact-btn" title="Call">
                                <i class="las la-phone"></i>
                            </a>
                            <a href="#" class="contact-btn" title="Message">
                                <i class="las la-comment"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="las la-chalkboard-teacher"></i>
                        <h4>No tutors found</h4>
                        <p>No tutors have registered yet.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Enrollments -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Enrollments</h3>
                <a href="{{ route('admin.enrollments') }}" class="btn-secondary">
                    See all <i class="las la-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentEnrollments) && $recentEnrollments->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEnrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium">{{ $enrollment->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($enrollment->type == 'class' && $enrollment->class)
                                            {{ Str::limit($enrollment->class->title, 30) }}
                                        @elseif($enrollment->type == 'bootcamp' && $enrollment->bootcamp)
                                            {{ Str::limit($enrollment->bootcamp->title, 30) }}
                                        @else
                                            <span class="text-muted">Course not found</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $enrollment->type == 'class' ? 'info' : 'primary' }}">
                                            {{ ucfirst($enrollment->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $enrollment->status }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="las la-user-check"></i>
                        <h4>No enrollments found</h4>
                        <p>No students have enrolled yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <!--<div class="quick-actions">
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="actions-grid">
                    <a href="{{ route('admin.members') }}" class="action-btn">
                        <i class="las la-user-plus"></i>
                        Manage Members
                    </a>
                    
                    <a href="{{ route('admin.classes') }}" class="action-btn gold">
                        <i class="las la-graduation-cap"></i>
                        Manage Classes
                    </a>
                    
                    <a href="{{ route('admin.payments') }}" class="action-btn green">
                        <i class="las la-credit-card"></i>
                        View Payments
                    </a>
                    
                    <a href="{{ route('admin.tasks') }}" class="action-btn blue">
                        <i class="las la-tasks"></i>
                        Manage Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Recent Task Submissions -->
    @if(isset($recentTaskSubmissions) && $recentTaskSubmissions->count() > 0)
    <div class="dashboard-card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>Recent Task Submissions</h3>
            <a href="{{ route('admin.tasks') }}" class="btn-secondary">
                View All Tasks <i class="las la-arrow-right"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Task</th>
                            <th>Class</th>
                            <th>Submitted</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTaskSubmissions as $submission)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar" style="background: var(--primary-gold);">
                                        {{ strtoupper(substr($submission->student->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-medium">{{ $submission->student->name ?? 'Unknown Student' }}</span>
                                        <small style="display: block; color: #6b7280;">{{ $submission->student->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $submission->task->title ?? 'N/A' }}</strong>
                                    @if($submission->content)
                                    <small style="color: #6b7280; display: block; margin-top: 0.25rem;">
                                        {{ Str::limit($submission->content, 50) }}
                                    </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--primary-brown); font-weight: 500;">
                                    {{ $submission->task->class->title ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem;">
                                    {{ $submission->created_at->format('M d, Y') }}
                                    <small style="color: #6b7280; display: block;">
                                        {{ $submission->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge" style="background: {{ $submission->grade ? 'var(--success-green)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $submission->grade ? 'white' : 'var(--success-green)' }};">
                                    {{ $submission->grade ? 'Graded' : 'Submitted' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Dashboard interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations to cards
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

    // Action button hover effects
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
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