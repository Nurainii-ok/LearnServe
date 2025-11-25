@extends('layouts.admin')

<<<<<<< HEAD
@section('title', 'All Tasks')
=======
@section('title', 'Tasks Management')

@section('styles')
<style>
.page-container {
    padding: 0px;
    margin: 0;
    padding-top: 70px; /* Atur sesuai tinggi header */
}

.data-table-container {
    background: white;
    border-radius: 12px;
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

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-pending {
    background: rgba(236, 172, 87, 0.1);
    color: var(--primary-gold);
}

.status-in_progress {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.status-completed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.status-overdue {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.priority-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-left: 0.5rem;
}

.priority-high {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.priority-medium {
    background: rgba(236, 172, 87, 0.1);
    color: var(--primary-gold);
}

.priority-low {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
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

.alert {
    padding: 1rem;
    margin-bottom: 2rem;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.due-date {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.overdue {
    color: var(--error-red);
    font-weight: 600;
}
</style>
@endsection
>>>>>>> 6b8d8d75a398d844b6c63b83ea914317d1dedead

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">All Tasks Management</h4>
                    <p class="text-muted mb-0">Monitor all tasks created by tutors across the platform</p>
                </div>
                <div class="card-body">
                    @if($tasks->count() > 0)
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->total() }}</h4>
                                                <p class="mb-0">Total Tasks</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-tasks fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->where('status', 'completed')->count() }}</h4>
                                                <p class="mb-0">Completed</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-check-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->where('status', 'in_progress')->count() }}</h4>
                                                <p class="mb-0">In Progress</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-hourglass-half fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->where('status', 'overdue')->count() }}</h4>
                                                <p class="mb-0">Overdue</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-exclamation-triangle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Table -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Class</th>
                                        <th>Tutor</th>
                                        <th>Due Date</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Submissions</th>
                                        <th>Graded</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $task->class->title }}</span>
                                            </td>
                                            <td>
                                                {{ $task->assignedBy->name }}
                                                <br>
                                                <small class="text-muted">{{ $task->assignedBy->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }}">
                                                    {{ $task->due_date->format('M d, Y') }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $task->due_date->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($task->priority === 'high') bg-danger
                                                    @elseif($task->priority === 'medium') bg-warning
                                                    @else bg-success
                                                    @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($task->status === 'completed') bg-success
                                                    @elseif($task->status === 'overdue') bg-danger
                                                    @elseif($task->status === 'in_progress') bg-warning
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $task->submissions->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $task->submissions->whereNotNull('grade')->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $task->created_at->format('M d, Y') }}
                                                <br>
                                                <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-tasks display-1 text-muted"></i>
                            <h5 class="mt-3">No Tasks Found</h5>
                            <p class="text-muted">No tasks have been created by tutors yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection