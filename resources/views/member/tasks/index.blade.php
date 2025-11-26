@extends('layouts.member')

@section('title', 'My Tasks')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4 tasks-header">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">My Tasks</h2>
                    <p class="text-muted mb-0">Manage and track your assignments</p>
                </div>
                @if($tasks->count() > 0)
                    <div class="badge bg-light text-dark fs-6 px-3 py-2">
                        {{ $tasks->total() }} Total Tasks
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($tasks->count() > 0)
        <!-- Tasks Grid -->
        <div class="row g-4">
            @foreach($tasks as $task)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="task-card h-100 
                        @if($task->is_overdue && !$task->submissions->first()) status-overdue
                        @elseif($task->submissions->first() && $task->submissions->first()->is_graded) status-graded
                        @elseif($task->submissions->first()) status-submitted
                        @else status-pending
                        @endif">
                        
                        <!-- Card Header -->
                        <div class="task-card-header">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <h5 class="task-title mb-0">{{ $task->title }}</h5>
                                <span class="priority-badge priority-{{ $task->priority }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="task-card-body">
                            <p class="task-description">{{ Str::limit($task->description, 120) }}</p>
                            
                            <!-- Class Info -->
                            <div class="task-info-item">
                                <i class="las la-book"></i>
                                <span>{{ $task->class->title }}</span>
                            </div>
                            
                            <!-- Due Date -->
                            <div class="task-info-item">
                                <i class="las la-calendar"></i>
                                <span>
                                    Due: 
                                    <span class="{{ $task->is_overdue ? 'text-danger fw-semibold' : '' }}">
                                        {{ $task->due_date->format('M d, Y H:i') }}
                                    </span>
                                </span>
                            </div>

                            @php
                                $submission = $task->submissions->first();
                            @endphp

                            <!-- Status Section -->
                            <div class="task-status-section">
                                @if($submission)
                                    @if($submission->is_graded)
                                        <div class="status-badge status-badge-success">
                                            <i class="las la-check-circle"></i>
                                            <div>
                                                <div class="status-label">Graded</div>
                                                <div class="status-value">{{ $submission->grade }}/100 ({{ $submission->grade_letter }})</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="status-badge status-badge-warning">
                                            <i class="las la-clock"></i>
                                            <div>
                                                <div class="status-label">Submitted</div>
                                                <div class="status-value">Pending Grade</div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($submission->is_late)
                                        <div class="late-indicator">
                                            <i class="las la-exclamation-circle"></i> Late Submission
                                        </div>
                                    @endif
                                @else
                                    @if($task->is_overdue)
                                        <div class="status-badge status-badge-danger">
                                            <i class="las la-exclamation-triangle"></i>
                                            <div>
                                                <div class="status-label">Overdue</div>
                                                <div class="status-value">Submit immediately</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="status-badge status-badge-info">
                                            <i class="las la-hourglass-half"></i>
                                            <div>
                                                <div class="status-label">Not Submitted</div>
                                                <div class="status-value">Action required</div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="task-card-footer">
                            <a href="{{ route('member.tasks.show', $task) }}" class="btn-task-action">
                                @if($submission)
                                    <i class="las la-eye"></i> View Submission
                                @else
                                    <i class="las la-edit"></i> Submit Task
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="las la-tasks"></i>
            </div>
            <h4 class="empty-state-title">No Tasks Available</h4>
            <p class="empty-state-text">You don't have any tasks assigned yet. Check back later or contact your instructor.</p>
        </div>
    @endif
</div>

<style>

.tasks-header {
    padding-top: 30px; /* atau 32px */
}

/* Modern Task Card Styles */
.task-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.task-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.15);
    border-color: #d1d5db;
}

/* Status Border Colors */
.task-card.status-overdue {
    border-left: 4px solid #ef4444;
}

.task-card.status-graded {
    border-left: 4px solid #10b981;
}

.task-card.status-submitted {
    border-left: 4px solid #f59e0b;
}

.task-card.status-pending {
    border-left: 4px solid #3b82f6;
}

/* Card Header */
.task-card-header {
    padding: 20px 24px;
    background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
    border-bottom: 1px solid #f3f4f6;
}

.task-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    line-height: 1.4;
}

/* Priority Badge */
.priority-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.priority-high {
    background: #fee2e2;
    color: #991b1b;
}

.priority-medium {
    background: #fef3c7;
    color: #92400e;
}

.priority-low {
    background: #d1fae5;
    color: #065f46;
}

/* Card Body */
.task-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.task-description {
    color: #6b7280;
    font-size: 0.9375rem;
    line-height: 1.6;
    margin: 0;
}

.task-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6b7280;
    font-size: 0.875rem;
}

.task-info-item i {
    font-size: 1.25rem;
    color: #9ca3af;
}

/* Status Section */
.task-status-section {
    margin-top: auto;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 12px;
    background: #f9fafb;
}

.status-badge i {
    font-size: 1.5rem;
}

.status-label {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.8;
}

.status-value {
    font-size: 0.875rem;
    font-weight: 600;
    margin-top: 2px;
}

.status-badge-success {
    background: #f0fdf4;
    color: #15803d;
}

.status-badge-success i {
    color: #22c55e;
}

.status-badge-warning {
    background: #fffbeb;
    color: #a16207;
}

.status-badge-warning i {
    color: #f59e0b;
}

.status-badge-danger {
    background: #fef2f2;
    color: #991b1b;
}

.status-badge-danger i {
    color: #ef4444;
}

.status-badge-info {
    background: #eff6ff;
    color: #1e40af;
}

.status-badge-info i {
    color: #3b82f6;
}

.late-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #fef2f2;
    color: #991b1b;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
}

/* Card Footer */
.task-card-footer {
    padding: 20px 24px;
    background: #fafafa;
    border-top: 1px solid #f3f4f6;
}

.btn-task-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-task-action:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-task-action i {
    font-size: 1.25rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-state-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 50%;
    margin-bottom: 24px;
}

.empty-state-icon i {
    font-size: 4rem;
    color: #9ca3af;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
}

.empty-state-text {
    font-size: 1rem;
    color: #6b7280;
    max-width: 500px;
    margin: 0 auto;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .task-card-header,
    .task-card-body,
    .task-card-footer {
        padding: 16px 20px;
    }
    
    .task-title {
        font-size: 1rem;
    }
    
    .priority-badge {
        font-size: 0.6875rem;
        padding: 3px 10px;
    }
}
</style>
@endsection