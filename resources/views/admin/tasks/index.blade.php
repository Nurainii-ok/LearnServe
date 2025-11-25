@extends('layouts.admin')

@section('title', 'All Tasks')

@section('styles')
<style>
    :root {
        --primary-brown: #944e25;
        --primary-gold: #ecac57;
        --light-cream: #f3efec;
        --deep-brown: #6b3419;
        --soft-gold: #f4d084;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --success-green: #10b981;
        --error-red: #ef4444;
        --warning-orange: #f59e0b;
        --info-blue: #3b82f6;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
    }

    /* Page Container */
    .page-container {
        background: var(--bg-light);
        min-height: 100vh;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    /* Card Styles */
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: white;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .card-body {
        padding: 0;
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        text-align: left;
        padding: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--bg-light);
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        vertical-align: top;
    }

    .data-table tbody tr {
        transition: background 0.2s;
    }

    .data-table tbody tr:hover {
        background: var(--bg-light);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Task Info */
    .task-title {
        font-weight: 600;
        color: var(--text-primary);
        display: block;
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .task-description {
        color: var(--text-secondary);
        font-size: 0.8rem;
        line-height: 1.4;
    }

    /* Tutor Info */
    .tutor-name {
        font-weight: 500;
        color: var(--text-primary);
        display: block;
    }

    .tutor-email {
        color: var(--text-secondary);
        font-size: 0.75rem;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-class {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-date {
        background: #f3f4f6;
        color: var(--text-primary);
        font-weight: 500;
    }

    .badge-date.overdue {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-priority-high {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-priority-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-priority-low {
        background: #dcfce7;
        color: #166534;
    }

    .badge-status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .badge-status-overdue {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-status-in_progress {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-status-pending {
        background: #f3f4f6;
        color: #6b7280;
    }

    .badge-count {
        background: var(--info-blue);
        color: white;
        min-width: 28px;
        text-align: center;
        justify-content: center;
    }

    .badge-count.success {
        background: var(--success-green);
    }

    /* Date & Time Display */
    .date-display {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }

    .date-main {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .date-time {
        color: var(--text-secondary);
        font-size: 0.75rem;
    }

    .date-relative {
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-style: italic;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        color: var(--primary-brown);
    }

    .empty-state h5 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.95rem;
    }

    /* Pagination */
    .pagination-container {
        padding: 1.5rem;
        display: flex;
        justify-content: center;
        border-top: 1px solid var(--border-color);
        background: var(--bg-light);
    }

    /* Stats Summary (Optional) */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-icon.primary {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-blue);
    }

    .stat-icon.success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-green);
    }

    .stat-icon.warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-orange);
    }

    .stat-icon.danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-red);
    }

    .stat-info h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.125rem 0;
        color: var(--text-primary);
    }

    .stat-info p {
        margin: 0;
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-container {
            padding: 1rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .card-header {
            padding: 1rem;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .stats-summary {
            grid-template-columns: 1fr;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>All Tasks</h1>
        <p class="page-subtitle">Monitor all tasks created by tutors across the platform</p>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-body">
            @if($tasks->count() > 0)
                <!-- Optional: Stats Summary -->
                <!-- Uncomment to enable stats display -->
                <!--
                <div class="stats-summary" style="padding: 1.5rem; padding-bottom: 0;">
                    <div class="stat-item">
                        <div class="stat-icon primary">
                            <i class="las la-tasks"></i>
                        </div>
                        <div class="stat-info">
                            <h4>{{ $tasks->total() }}</h4>
                            <p>Total Tasks</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon success">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h4>{{ $tasks->where('status', 'completed')->count() }}</h4>
                            <p>Completed</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon warning">
                            <i class="las la-hourglass-half"></i>
                        </div>
                        <div class="stat-info">
                            <h4>{{ $tasks->where('status', 'in_progress')->count() }}</h4>
                            <p>In Progress</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon danger">
                            <i class="las la-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h4>{{ $tasks->where('status', 'overdue')->count() }}</h4>
                            <p>Overdue</p>
                        </div>
                    </div>
                </div>
                -->

                <!-- Tasks Table -->
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Class</th>
                                <th>Tutor</th>
                                <th>Due Date</th>
                                <!--<th>Priority</th>
                                <th>Status</th>-->
                                <th>Submissions</th>
                                <th>Graded</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <!-- Task -->
                                    <td style="min-width: 200px;">
                                        <span class="task-title">{{ $task->title }}</span>
                                        <span class="task-description">{{ Str::limit($task->description, 60) }}</span>
                                    </td>

                                    <!-- Class -->
                                    <td>
                                        <span class="badge badge-class">{{ $task->class->title }}</span>
                                    </td>

                                    <!-- Tutor -->
                                    <td style="min-width: 150px;">
                                        <span class="tutor-name">{{ $task->assignedBy->name }}</span>
                                        <span class="tutor-email">{{ $task->assignedBy->email }}</span>
                                    </td>

                                    <!-- Due Date -->
                                    <td>
                                        <div class="date-display">
                                            <span class="badge badge-date {{ $task->is_overdue ? 'overdue' : '' }}">
                                                {{ $task->due_date->format('M d, Y') }}
                                            </span>
                                            <span class="date-time">{{ $task->due_date->format('H:i') }}</span>
                                        </div>
                                    </td>

                                    <!-- Priority -->
                                    <!--<td>
                                        <span class="badge badge-priority-{{ $task->priority }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>-->

                                    <!-- Status -->
                                    <!--<td>
                                        <span class="badge badge-status-{{ $task->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>-->

                                    <!-- Submissions -->
                                    <td>
                                        <span class="badge badge-count">
                                            {{ $task->submissions->count() }}
                                        </span>
                                    </td>

                                    <!-- Graded -->
                                    <td>
                                        <span class="badge badge-count success">
                                            {{ $task->submissions->whereNotNull('grade')->count() }}
                                        </span>
                                    </td>

                                    <!-- Created -->
                                    <td style="min-width: 120px;">
                                        <div class="date-display">
                                            <span class="date-main">{{ $task->created_at->format('M d, Y') }}</span>
                                            <span class="date-relative">{{ $task->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $tasks->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <h5>No Tasks Found</h5>
                    <p>No tasks have been created by tutors yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection