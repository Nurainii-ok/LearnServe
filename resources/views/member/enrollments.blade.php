@extends('layouts.member')

@section('title', 'My Enrollments')

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

.container-xxl {
    margin-top: 40px;
    padding: 0 20px;
}

.page-header {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.page-header p {
    color: var(--text-secondary);
    margin: 0;
    font-size: 1rem;
}

.table-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
}

.enrollment-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.enrollment-table thead {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
}

.enrollment-table thead th {
    padding: 1.25rem 1.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
    color: black !important;
}

.enrollment-table thead th:first-child {
    border-radius: 16px 0 0 0;
}

.enrollment-table thead th:last-child {
    border-radius: 0 16px 0 0;
}

.enrollment-table tbody tr {
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.2s ease;
}

.enrollment-table tbody tr:hover {
    background-color: #fafafa;
}

.enrollment-table tbody tr:last-child {
    border-bottom: none;
}

.enrollment-table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: var(--text-primary);
}

.course-cell {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 300px;
}

.course-image {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background: var(--light-cream);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-image i {
    font-size: 1.75rem;
    color: var(--primary-brown);
}

.course-info {
    flex: 1;
    min-width: 0;
}

.course-title {
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-tutor {
    font-size: 0.875rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.course-tutor i {
    color: var(--primary-gold);
    font-size: 1rem;
}

.type-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 500;
    white-space: nowrap;
}

.type-class {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.type-bootcamp {
    background: rgba(147, 51, 234, 0.1);
    color: #7c3aed;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 500;
    white-space: nowrap;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.status-completed {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.status-dropped {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.price-cell {
    font-weight: 700;
    color: var(--primary-brown);
    font-size: 1rem;
    white-space: nowrap;
}

.date-cell {
    font-size: 0.875rem;
    color: var(--text-secondary);
    white-space: nowrap;
}

.progress-cell {
    min-width: 120px;
}

.progress-bar-container {
    width: 100%;
    height: 8px;
    background: #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 0.25rem;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-gold), var(--soft-gold));
    border-radius: 10px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.75rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.actions-cell {
    text-align: center;
}

.btn-unenroll {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
    border: 1px solid rgba(239, 68, 68, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-unenroll:hover {
    background: var(--error-red);
    color: white;
    border-color: var(--error-red);
}

.empty-state {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: var(--text-secondary);
    opacity: 0.5;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 600;
}

.empty-state p {
    color: var(--text-secondary);
    margin: 0 0 2rem 0;
}

.btn-browse {
    background: var(--primary-brown);
    color: white;
    padding: 0.875rem 1.75rem;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-browse:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(148, 78, 37, 0.3);
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .enrollment-table {
        font-size: 0.875rem;
    }
    
    .enrollment-table thead th,
    .enrollment-table tbody td {
        padding: 1rem;
    }
}

@media (max-width: 768px) {
    .container-xxl {
        padding: 0 12px;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .table-wrapper {
        border-radius: 12px;
    }
    
    .course-cell {
        min-width: 250px;
    }
    
    .course-image {
        width: 50px;
        height: 50px;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <!--<div class="page-header">
        <h1>My Enrollments</h1>
        <p>Track all your enrolled classes and payment history</p>
    </div>-->

    @if($enrollments->count() > 0)
        <!-- Enrollments Table -->
        <div class="table-container">
            <div class="table-wrapper">
                <table class="enrollment-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Enrolled Date</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr>
                            <!-- Course Column -->
                            <td>
                                <div class="course-cell">
                                    <div class="course-image">
                                        @if($enrollment->type === 'class' && $enrollment->class && $enrollment->class->image)
                                            <img src="{{ asset($enrollment->class->image) }}" alt="{{ $enrollment->class->title }}">
                                        @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp && $enrollment->bootcamp->image)
                                            <img src="{{ asset($enrollment->bootcamp->image) }}" alt="{{ $enrollment->bootcamp->title }}">
                                        @else
                                            <i class="bx {{ $enrollment->type === 'class' ? 'bx-book' : 'bx-code-alt' }}"></i>
                                        @endif
                                    </div>
                                    <div class="course-info">
                                        <h4 class="course-title">
                                            @if($enrollment->type === 'class' && $enrollment->class)
                                                {{ $enrollment->class->title }}
                                            @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                                {{ $enrollment->bootcamp->title }}
                                            @else
                                                Course Title
                                            @endif
                                        </h4>
                                        <div class="course-tutor">
                                            <i class="bx bx-user"></i>
                                            @if($enrollment->type === 'class' && $enrollment->class && $enrollment->class->tutor)
                                                {{ $enrollment->class->tutor->name }}
                                            @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp && $enrollment->bootcamp->tutor)
                                                {{ $enrollment->bootcamp->tutor->name }}
                                            @else
                                                No Tutor
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Type Column -->
                            <td>
                                <span class="type-badge type-{{ $enrollment->type }}">
                                    {{ ucfirst($enrollment->type) }}
                                </span>
                            </td>

                            <!-- Price Column -->
                            <td class="price-cell">
                                @if($enrollment->type === 'class' && $enrollment->class)
                                    Rp{{ number_format($enrollment->class->price, 0, ',', '.') }}
                                @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                    Rp{{ number_format($enrollment->bootcamp->price, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </td>

                            <!-- Enrolled Date Column -->
                            <td class="date-cell">
                                {{ $enrollment->enrolled_at->format('M d, Y') }}
                            </td>

                            <!-- Progress Column -->
                            <td class="progress-cell">
                                <div class="progress-bar-container">
                                    <div class="progress-bar" style="width: {{ $enrollment->progress }}%"></div>
                                </div>
                                <div class="progress-text">{{ number_format($enrollment->progress, 1) }}%</div>
                            </td>

                            <!-- Status Column -->
                            <td>
                                <span class="status-badge status-{{ $enrollment->status }}">
                                    @if($enrollment->status === 'active')
                                        ✓ Active
                                    @elseif($enrollment->status === 'completed')
                                        🎉 Completed
                                    @elseif($enrollment->status === 'dropped')
                                        ❌ Dropped
                                    @else
                                        {{ ucfirst($enrollment->status) }}
                                    @endif
                                </span>
                            </td>

                            <!-- Action Column -->
                            <td class="actions-cell">
                                @if($enrollment->status === 'active')
                                <form action="{{ route('enrollment.unenroll', $enrollment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unenroll? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-unenroll">Unenroll</button>
                                </form>
                                @else
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($enrollments->hasPages())
        <div class="pagination-wrapper">
            {{ $enrollments->links() }}
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="bx bx-book-bookmark"></i>
            <h3>No Enrollments Yet</h3>
            <p>You haven't enrolled in any classes yet. Browse our available classes and start your learning journey!</p>
            <a href="{{ route('learning') }}" class="btn-browse">Browse Classes</a>
        </div>
    @endif
</div>
@endsection