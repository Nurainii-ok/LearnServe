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
    /*box-shadow: 0 4px 15px rgba(0,0,0,0.1);*/
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
    /*box-shadow: 0 2px 10px rgba(0,0,0,0.08);*/
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

/* TABEL ENROLLMENT*/
.enrollment-table-container {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.enrollment-table {
    width: 100%;
    border-collapse: collapse;
}

.enrollment-table thead {
    background: var(--light-cream);
}

.enrollment-table th,
.enrollment-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.enrollment-table th {
    color: var(--primary-brown);
    font-weight: 600;
}

.student-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.student-avatar-sm {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-brown);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.progress-bar-wrap {
    width: 100%;
    height: 8px;
    background: #f3f4f6;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-sm {
    height: 8px;
    background: linear-gradient(90deg, var(--primary-gold), var(--soft-gold));
    border-radius: 4px;
}

.table-actions {
    display: flex;
    gap: 8px;
}

.table-btn {
    padding: 6px 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    border: none;
}

.table-btn-view {
    background: var(--info-blue);
    color: white;
}

.table-btn-delete {
    background: var(--error-red);
    color: white;
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
    <!--<div class="page-header">
        <h1>Enrollments Management</h1>
        <p>Manage student enrollments and track their progress</p>
    </div>-->

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
        <div class="enrollment-table-container">
<table class="enrollment-table">
    <thead>
        <tr>
            <th>Student</th>
            <th>Course</th>
            <th>Type</th>
            <th>Status</th>
            <th>Progress</th>
            <th>Tanggal Pendaftaran</th>
            <!--<th>Completed</th>-->
            <!--<th>Actions</th>-->
        </tr>
    </thead>

    <tbody>
        @foreach($enrollments as $enrollment)
        <tr>
            <!-- Student -->
            <td>
                <div class="student-cell">
                    <div class="student-avatar-sm">
                        {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <strong>{{ $enrollment->user->name }}</strong><br>
                        <small>{{ $enrollment->user->email }}</small>
                    </div>
                </div>
            </td>

            <!-- Course Title -->
            <td>
                @if($enrollment->type == 'class' && $enrollment->class)
                    {{ $enrollment->class->title }}
                @elseif($enrollment->type == 'bootcamp' && $enrollment->bootcamp)
                    {{ $enrollment->bootcamp->title }}
                @else
                    <span class="text-muted">Course not found</span>
                @endif
            </td>

            <!-- Type -->
            <td>
                <span class="type-badge type-{{ $enrollment->type }}">
                    {{ ucfirst($enrollment->type) }}
                </span>
            </td>

            <!-- Status -->
            <td>
                <span class="status-badge status-{{ $enrollment->status }}">
                    {{ ucfirst($enrollment->status) }}
                </span>
            </td>

            <!-- Progress -->
            <td style="min-width:140px;">
                <div class="progress-bar-wrap">
                    <div class="progress-bar-sm" style="width: {{ $enrollment->progress }}%"></div>
                </div>
                <small>{{ number_format($enrollment->progress, 1) }}%</small>
            </td>

            <!-- Enrolled Date -->
            <td>{{ $enrollment->enrolled_at? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}</td>

            <!-- Completed Date -->
            <!--<td>
                @if($enrollment->completed_at)
                    {{ $enrollment->completed_at->format('M d, Y') }}
                @else
                    -
                @endif
            </td>-->

            <!-- Actions -->
            <!--<td>
                <div class="table-actions">
                    <button class="table-btn table-btn-view" data-bs-toggle="modal" data-bs-target="#viewModal{{ $enrollment->id }}">
                        <i class="bx bx-show"></i>
                    </button>

                    <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="table-btn table-btn-delete" onclick="return confirm('Delete this enrollment?')">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>
                </div>
            </td>-->
        </tr>
        @endforeach
    </tbody>
</table>
</div>


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