@extends('layouts.admin')

@section('title', 'Enrollments Management')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --success-green: #10b981;
    --warning-yellow: #f59e0b;
    --error-red: #ef4444;
    --info-blue: #3b82f6;
}

.page-header {
    background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.page-header p {
    margin: 0;
    opacity: 0.9;
}

.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    text-align: center;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-brown);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.enrollment-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.enrollment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.enrollment-header {
    background: var(--light-cream);
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: between;
    align-items: center;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.student-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--primary-brown);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
}

.student-details h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: var(--primary-brown);
}

.student-details small {
    color: #6b7280;
}

.enrollment-status {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active { background: rgba(16, 185, 129, 0.1); color: var(--success-green); }
.status-completed { background: rgba(59, 130, 246, 0.1); color: var(--info-blue); }
.status-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning-yellow); }
.status-dropped { background: rgba(239, 68, 68, 0.1); color: var(--error-red); }

.type-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.type-class { background: rgba(59, 130, 246, 0.1); color: var(--info-blue); }
.type-bootcamp { background: rgba(148, 78, 37, 0.1); color: var(--primary-brown); }

.enrollment-body {
    padding: 1.5rem;
}

.course-info {
    margin-bottom: 1.5rem;
}

.course-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--primary-brown);
    margin-bottom: 0.5rem;
}

.course-meta {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.course-meta i {
    color: var(--primary-gold);
}

.progress-section {
    margin-bottom: 1.5rem;
}

.progress-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.progress-label {
    font-weight: 500;
    color: var(--primary-brown);
}

.progress-percentage {
    font-weight: 600;
    color: var(--primary-brown);
}

.progress-bar-container {
    width: 100%;
    height: 8px;
    background: #f3f4f6;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-gold), var(--soft-gold));
    border-radius: 4px;
    transition: width 0.3s ease;
}

.enrollment-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.btn-action {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-view {
    background: var(--info-blue);
    color: white;
}

.btn-view:hover {
    background: #2563eb;
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: var(--error-red);
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
}

.filter-section {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--primary-brown);
}

.filter-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
}

.filter-input:focus {
    outline: none;
    border-color: var(--primary-gold);
    box-shadow: 0 0 0 3px rgba(236, 172, 87, 0.1);
}

.btn-filter {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: var(--deep-brown);
}

.btn-reset {
    background: #6b7280;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-reset:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.empty-state i {
    font-size: 4rem;
    color: var(--primary-gold);
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .enrollment-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .course-meta {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .enrollment-actions {
        justify-content: center;
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Enrollments Management</h1>
        <p>Manage student enrollments and track their progress</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-number">{{ $enrollments->total() }}</div>
            <div class="stat-label">Total Enrollments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $enrollments->where('status', 'active')->count() }}</div>
            <div class="stat-label">Active Students</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $enrollments->where('type', 'class')->count() }}</div>
            <div class="stat-label">Class Enrollments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $enrollments->where('type', 'bootcamp')->count() }}</div>
            <div class="stat-label">Bootcamp Enrollments</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.enrollments') }}">
            <div class="filter-grid">
                <div class="filter-group">
                    <label>Course Type</label>
                    <select name="type" class="filter-input">
                        <option value="">All Types</option>
                        <option value="class" {{ request('type') == 'class' ? 'selected' : '' }}>Class</option>
                        <option value="bootcamp" {{ request('type') == 'bootcamp' ? 'selected' : '' }}>Bootcamp</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Search Student</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Student name or email" class="filter-input">
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn-filter">
                        <i class="bx bx-search"></i> Filter
                    </button>
                </div>
                <div class="filter-group">
                    <a href="{{ route('admin.enrollments') }}" class="btn-reset">
                        <i class="bx bx-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Enrollments List -->
    @if($enrollments->count() > 0)
        @foreach($enrollments as $enrollment)
        <div class="enrollment-card">
            <div class="enrollment-header">
                <div class="student-info">
                    <div class="student-avatar">
                        {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                    </div>
                    <div class="student-details">
                        <h6>{{ $enrollment->user->name }}</h6>
                        <small>{{ $enrollment->user->email }}</small>
                    </div>
                </div>
                <div class="enrollment-status">
                    <span class="type-badge type-{{ $enrollment->type }}">
                        {{ ucfirst($enrollment->type) }}
                    </span>
                    <span class="status-badge status-{{ $enrollment->status }}">
                        {{ ucfirst($enrollment->status) }}
                    </span>
                </div>
            </div>
            
            <div class="enrollment-body">
                <div class="course-info">
                    @if($enrollment->type == 'class' && $enrollment->class)
                        <div class="course-title">{{ $enrollment->class->title }}</div>
                        <div class="course-meta">
                            <span><i class="bx bx-user"></i> {{ $enrollment->class->tutor->name ?? 'Unknown Tutor' }}</span>
                            <span><i class="bx bx-calendar"></i> Enrolled {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}</span>
                            @if($enrollment->completed_at)
                                <span><i class="bx bx-check-circle"></i> Completed {{ $enrollment->completed_at->format('M d, Y') }}</span>
                            @endif
                        </div>
                    @elseif($enrollment->type == 'bootcamp' && $enrollment->bootcamp)
                        <div class="course-title">{{ $enrollment->bootcamp->title }}</div>
                        <div class="course-meta">
                            <span><i class="bx bx-user"></i> {{ $enrollment->bootcamp->tutor->name ?? 'Unknown Tutor' }}</span>
                            <span><i class="bx bx-calendar"></i> Enrolled {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}</span>
                            @if($enrollment->completed_at)
                                <span><i class="bx bx-check-circle"></i> Completed {{ $enrollment->completed_at->format('M d, Y') }}</span>
                            @endif
                        </div>
                    @else
                        <div class="course-title text-muted">Course not found</div>
                        <div class="course-meta">
                            <span><i class="bx bx-error-circle"></i> Course may have been deleted</span>
                        </div>
                    @endif
                </div>

                <div class="progress-section">
                    <div class="progress-header">
                        <span class="progress-label">Learning Progress</span>
                        <span class="progress-percentage">{{ number_format($enrollment->progress, 1) }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ $enrollment->progress }}%"></div>
                    </div>
                </div>

                @if($enrollment->notes)
                <div class="notes-section">
                    <strong>Notes:</strong> {{ $enrollment->notes }}
                </div>
                @endif

                <div class="enrollment-actions">
                    <button type="button" class="btn-action btn-view" data-bs-toggle="modal" data-bs-target="#viewModal{{ $enrollment->id }}">
                        <i class="bx bx-show"></i> View Details
                    </button>
                    <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" 
                                onclick="return confirm('Are you sure you want to delete this enrollment?')">
                            <i class="bx bx-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal{{ $enrollment->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enrollment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Student:</th>
                                        <td>{{ $enrollment->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $enrollment->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course:</th>
                                        <td>
                                            @if($enrollment->type == 'class' && $enrollment->class)
                                                {{ $enrollment->class->title }}
                                            @elseif($enrollment->type == 'bootcamp' && $enrollment->bootcamp)
                                                {{ $enrollment->bootcamp->title }}
                                            @else
                                                Course not found
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Type:</th>
                                        <td>{{ ucfirst($enrollment->type) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Status:</th>
                                        <td>
                                            <span class="status-badge status-{{ $enrollment->status }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Progress:</th>
                                        <td>{{ number_format($enrollment->progress, 1) }}%</td>
                                    </tr>
                                    <tr>
                                        <th>Enrolled Date:</th>
                                        <td>{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    </tr>
                                    @if($enrollment->completed_at)
                                    <tr>
                                        <th>Completed Date:</th>
                                        <td>{{ $enrollment->completed_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        @if($enrollment->notes)
                        <div class="mt-3">
                            <strong>Notes:</strong>
                            <p class="mt-2">{{ $enrollment->notes }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        @if($enrollments->hasPages())
        <div class="pagination-wrapper">
            {{ $enrollments->links() }}
        </div>
        @endif
    @else
        <div class="empty-state">
            <i class="bx bx-user-check"></i>
            <h3>No Enrollments Found</h3>
            <p>No students have enrolled in any courses yet, or no enrollments match your current filters.</p>
            <a href="{{ route('admin.enrollments') }}" class="btn-reset">Clear Filters</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations to enrollment cards
    const cards = document.querySelectorAll('.enrollment-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Progress bar animation
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });
});
</script>
@endsection