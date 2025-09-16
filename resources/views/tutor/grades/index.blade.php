@extends('layouts.tutor')

@section('title', 'Student Grades')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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

.dashboard-content {
    padding: 0;
    margin: 0;
    padding-top: 1rem;
}

.data-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.table-header {
    background: var(--light-cream);
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h2 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.25rem;
    font-weight: 600;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
}

.data-table th {
    background: #f9fafb;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 2px solid #e5e7eb;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

.grade-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    min-width: 2rem;
    text-align: center;
}

.grade-A {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.grade-B {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.grade-C {
    background: rgba(236, 172, 87, 0.1);
    color: var(--primary-gold);
}

.grade-D {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.grade-F {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.type-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.type-assignment {
    background: rgba(148, 78, 37, 0.1);
    color: var(--primary-brown);
}

.type-quiz {
    background: rgba(236, 172, 87, 0.1);
    color: var(--primary-gold);
}

.type-exam {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.type-project {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.type-participation {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-edit {
    background: var(--primary-gold);
    color: white;
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.75rem;
    transition: all 0.3s;
}

.btn-edit:hover {
    background: var(--soft-gold);
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: var(--error-red);
    color: white;
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-delete:hover {
    background: #dc2626;
}

.pagination-container {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f9fafb;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #d1d5db;
}

.score {
    font-weight: 600;
    font-size: 1rem;
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="data-table-container">
        <div class="table-header">
            <h2>Student Grades</h2>
            <a href="{{ route('tutor.grades.create') }}" class="btn-primary">
                <i class="las la-plus"></i> Add Grade
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: var(--success-green); padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                {{ session('success') }}
            </div>
        @endif

        @if($grades->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Task/Assignment</th>
                            <th>Type</th>
                            <th>Score</th>
                            <th>Grade</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $grade->student->name }}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.75rem;">{{ $grade->student->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $grade->class->title }}</strong>
                                </td>
                                <td>
                                    @if($grade->task)
                                        <div>
                                            <strong>{{ $grade->task->title }}</strong>
                                        </div>
                                    @else
                                        <span style="color: var(--text-secondary); font-style: italic;">General Grade</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="type-badge type-{{ $grade->type }}">
                                        {{ ucfirst($grade->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="score">{{ number_format($grade->score, 1) }}%</span>
                                </td>
                                <td>
                                    <span class="grade-badge grade-{{ $grade->grade }}">
                                        {{ $grade->grade }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.875rem;">
                                        {{ $grade->created_at->format('M d, Y') }}
                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $grade->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('tutor.grades.edit', $grade->id) }}" class="btn-edit">
                                            <i class="las la-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('tutor.grades.destroy', $grade->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this grade?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="las la-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $grades->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="las la-graduation-cap"></i>
                <h3>No grades found</h3>
                <p>You haven't added any grades yet. <a href="{{ route('tutor.grades.create') }}" style="color: var(--primary-brown);">Add your first grade</a></p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to table rows
    const rows = document.querySelectorAll('.data-table tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
@endsection