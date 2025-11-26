@extends('layouts.tutor')

@section('title', 'My Tasks')

@section('styles')
<style>
    :root {
        --primary-brown: #8b4513;
        --primary-gold: #d4af37;
        --success-green: #10b981;
        --danger-red: #ef4444;
        --warning-orange: #f59e0b;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-gray: #f8fafc;
    }

    .page-container {
        background: var(--bg-gray);
        min-height: 100vh;
        padding: 2rem 1rem;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .btn-primary {
        background: var(--primary-brown);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        background: #6d3610;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin-bottom: 1.5rem;
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
        margin: 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-close:hover {
        opacity: 1;
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        margin: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        text-align: left;
        padding: 0.875rem 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--bg-gray);
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: background 0.2s;
    }

    .data-table tbody tr:hover {
        background: var(--bg-gray);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Task Info */
    .task-info strong {
        color: var(--text-primary);
        font-weight: 600;
        display: block;
        margin-bottom: 0.25rem;
    }

    .task-description {
        color: var(--text-secondary);
        font-size: 0.75rem;
        line-height: 1.4;
    }

    .class-info strong {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Badges */
    .priority-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
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
        background: #dbeafe;
        color: #1e40af;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-draft {
        background: #f3f4f6;
        color: #4b5563;
    }

    /* Due Date */
    .due-date {
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.875rem;
    }

    .due-date.overdue {
        color: var(--danger-red);
        font-weight: 600;
    }

    .due-date div {
        font-size: 0.7rem;
        color: var(--text-secondary);
        margin-top: 0.125rem;
    }

    /* Submissions Count */
    .submissions-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .submission-count {
        padding: 0.25rem 0.625rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        color: white;
        min-width: 28px;
        text-align: center;
    }

    .submission-count.has-submissions {
        background: var(--success-green);
    }

    .submission-count.no-submissions {
        background: #9ca3af;
    }

    .view-link {
        color: var(--primary-brown);
        font-size: 0.75rem;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .view-link:hover {
        color: #6d3610;
        text-decoration: underline;
    }

    .no-submissions-text {
        color: var(--text-secondary);
        font-size: 0.75rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-edit, .btn-delete, .btn-view, .btn-grade {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-edit {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-edit:hover {
        background: #bfdbfe;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #fecaca;
    }

    .btn-view {
        background: #3b82f6;
        color: white;
    }

    .btn-view:hover {
        background: #2563eb;
    }

    .btn-grade {
        background: var(--primary-gold);
        color: white;
    }

    .btn-grade:hover {
        background: #c19a2e;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        margin: 0;
    }

    .empty-state a {
        color: var(--primary-brown);
        font-weight: 500;
        text-decoration: none;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-gold), var(--primary-brown));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .student-details strong {
        color: var(--text-primary);
        font-weight: 600;
        display: block;
    }

    .student-email {
        color: var(--text-secondary);
        font-size: 0.75rem;
    }

    /* Recent Submissions Section */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding: 0 0.5rem;
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .badge-new {
        background: var(--success-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        width: 100%;
        max-width: 800px;
        max-height: 85vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--primary-brown);
        font-size: 1.25rem;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.75rem;
        cursor: pointer;
        color: var(--text-secondary);
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: var(--bg-gray);
        color: var(--text-primary);
    }

    .modal-body {
        padding: 1.5rem;
        overflow-y: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1rem;
        }

        .data-table {
            font-size: 0.8rem;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 0.75rem 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .btn-edit, .btn-delete, .btn-view, .btn-grade {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>My Tasks</h1>
        <a href="{{ route('tutor.tasks.create') }}" class="btn-primary">
            <i class="las la-plus"></i> Create New Task
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                </div>
            @endif

            @if($tasks->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Class</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Submissions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td>
                                        <div class="task-info">
                                            <strong>{{ $task->title }}</strong>
                                            <div class="task-description">
                                                {{ Str::limit($task->description, 60) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="class-info">
                                            <strong>{{ $task->class->title }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="priority-badge priority-{{ $task->priority }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="due-date {{ \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'completed' ? 'overdue' : '' }}">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            <div>{{ \Carbon\Carbon::parse($task->due_date)->format('H:i') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $submissionCount = \App\Models\TaskSubmission::where('task_id', $task->id)->count();
                                        @endphp
                                        <div class="submissions-wrapper">
                                            <span class="submission-count {{ $submissionCount > 0 ? 'has-submissions' : 'no-submissions' }}">
                                                {{ $submissionCount }}
                                            </span>
                                            @if($submissionCount > 0)
                                                <a href="{{ route('tutor.tasks.submissions', $task->id) }}" class="view-link">
                                                    View All
                                                </a>
                                            @else
                                                <span class="no-submissions-text">No submissions</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $task->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('tutor.tasks.edit', $task->id) }}" class="btn-edit">
                                                <i class="las la-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('tutor.tasks.destroy', $task->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this task?')">
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
                    {{ $tasks->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="las la-tasks"></i>
                    <h3>No tasks found</h3>
                    <p>You haven't created any tasks yet. <a href="{{ route('tutor.tasks.create') }}">Create your first task</a></p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Submissions Section -->
    @if(isset($recentSubmissions) && $recentSubmissions->count() > 0)
    <div class="card">
        <div class="card-header">
            <div class="section-header">
                <h2>Recent Task Submissions</h2>
                <span class="badge-new">{{ $recentSubmissions->count() }} New</span>
            </div>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSubmissions as $submission)
                            <tr>
                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            {{ strtoupper(substr($submission->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div class="student-details">
                                            <strong>{{ $submission->student->name ?? 'Unknown Student' }}</strong>
                                            <span class="student-email">{{ $submission->student->email ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="task-info">
                                        <strong>{{ $submission->task->title }}</strong>
                                        @if($submission->content)
                                            <div class="task-description">
                                                {{ Str::limit($submission->content, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span style="color: var(--primary-brown); font-weight: 500;">
                                        {{ $submission->task->class->title ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="due-date">
                                        {{ $submission->created_at->format('M d, Y') }}
                                        <div>{{ $submission->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success-green);">
                                        {{ $submission->grade ? 'Graded' : 'Submitted' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($submission->file_path)
                                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn-view">
                                                <i class="las la-download"></i> File
                                            </a>
                                        @endif
                                        <a href="{{ route('tutor.bootcamp-tasks.review', $submission->id) }}" class="btn-grade">
                                            <i class="las la-edit"></i> Review
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Submissions Modal -->
    <div id="submissionsModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Task Submissions</h3>
                <button onclick="closeSubmissionsModal()" class="modal-close">&times;</button>
            </div>
            <div id="submissionsContent" class="modal-body">
                <!-- Submissions will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showSubmissions(taskId) {
    const modal = document.getElementById('submissionsModal');
    modal.classList.add('active');
    // Load submissions via AJAX here
}

function closeSubmissionsModal() {
    const modal = document.getElementById('submissionsModal');
    modal.classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('submissionsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeSubmissionsModal();
    }
});
</script>
@endsection