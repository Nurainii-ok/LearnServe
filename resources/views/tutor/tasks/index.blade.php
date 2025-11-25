@extends('layouts.tutor')

@section('title', 'My Tasks')

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

@section('content')
<div class="dashboard-content">
    <div class="data-table-container">
        <div class="table-header">
            <h2>My Tasks</h2>
            <a href="{{ route('tutor.tasks.create') }}" class="btn-primary">
                <i class="las la-plus"></i> Create New Task
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: var(--success-green); padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                {{ session('success') }}
            </div>
        @endif

        @if($tasks->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Bootcamp</th>
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
                                    <div>
                                        <strong>{{ $task->title }}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.25rem;">
                                            {{ Str::limit($task->description, 60) }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $task->bootcamp->title }}</strong>
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
                                        <div style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($task->due_date)->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $submissionCount = \App\Models\TaskSubmission::where('task_id', $task->id)->count();
                                    @endphp
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="submission-count" style="background: {{ $submissionCount > 0 ? 'var(--success-green)' : '#6b7280' }}; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $submissionCount }}
                                        </span>
                                        @if($submissionCount > 0)
                                        <a href="#" onclick="showSubmissions({{ $task->id }})" style="color: var(--primary-brown); font-size: 0.75rem; text-decoration: none;">
                                            View All
                                        </a>
                                        @else
                                        <span style="color: var(--text-secondary); font-size: 0.75rem;">No submissions</span>
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
                <p>You haven't created any tasks yet. <a href="{{ route('tutor.tasks.create') }}" style="color: var(--primary-brown);">Create your first task</a></p>
            </div>
        @endif
    </div>

    <!-- Recent Submissions Section -->
    @if(isset($recentSubmissions) && $recentSubmissions->count() > 0)
    <div class="data-table-container" style="margin-top: 2rem;">
        <div class="table-header">
            <h2>Recent Task Submissions</h2>
            <span class="badge" style="background: var(--success-green); color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem;">
                {{ $recentSubmissions->count() }} New
            </span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Task</th>
                        <th>Bootcamp</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSubmissions as $submission)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-gold); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.75rem;">
                                        {{ strtoupper(substr($submission->student->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $submission->student->name ?? 'Unknown Student' }}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                            {{ $submission->student->email ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $submission->task->bootcamp->title ?? 'N/A' }}</strong>
                                    @if($submission->content)
                                    <div style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.25rem;">
                                        {{ Str::limit($submission->content, 50) }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--primary-brown); font-weight: 500;">
                                    {{ $submission->task->bootcamp->title ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem;">
                                    {{ $submission->created_at->format('M d, Y') }}
                                    <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                        {{ $submission->created_at->format('H:i') }}
                                    </div>
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
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn-view" style="background: #3b82f6; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; text-decoration: none; font-size: 0.75rem;">
                                        <i class="las la-download"></i> File
                                    </a>
                                    @endif
                                    <button class="btn-grade" style="background: var(--primary-gold); color: white; padding: 0.25rem 0.5rem; border: none; border-radius: 4px; font-size: 0.75rem; cursor: pointer;">
                                        <i class="las la-star"></i> Grade
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Submissions Modal -->
    <div id="submissionsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: white; border-radius: 12px; width: 90%; max-width: 800px; max-height: 80vh; overflow-y: auto;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: var(--primary-brown);">Task Submissions</h3>
                <button onclick="closeSubmissionsModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-secondary);">&times;</button>
            </div>
            <div id="submissionsContent" style="padding: 1.5rem;">
                <!-- Submissions will be loaded here -->
            </div>
        </div>
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

function showSubmissions(taskId) {
    const modal = document.getElementById('submissionsModal');
    const content = document.getElementById('submissionsContent');
    
    // Show loading
    content.innerHTML = '<div style="text-align: center; padding: 2rem;"><i class="las la-spinner la-spin" style="font-size: 2rem;"></i><br>Loading submissions...</div>';
    modal.style.display = 'flex';
    
    // Fetch submissions for this task
    fetch(`/tutor/tasks/${taskId}/submissions`)
        .then(response => response.json())
        .then(data => {
            if (data.submissions && data.submissions.length > 0) {
                let html = '<div style="display: grid; gap: 1rem;">';
                
                data.submissions.forEach(submission => {
                    const submissionDate = new Date(submission.created_at).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    html += `
                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-gold); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                        ${submission.student.name.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <strong>${submission.student.name}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.875rem;">${submission.student.email}</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.875rem; color: var(--text-secondary);">${submissionDate}</div>
                                    <span style="background: ${submission.grade ? 'var(--success-green)' : 'rgba(16, 185, 129, 0.1)'}; color: ${submission.grade ? 'white' : 'var(--success-green)'}; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                        ${submission.grade ? `Graded (${submission.grade}%)` : 'Submitted'}
                                    </span>
                                </div>
                            </div>
                            
                            ${submission.content ? `
                                <div style="margin-bottom: 1rem;">
                                    <strong style="color: var(--primary-brown); font-size: 0.875rem;">Submission Text:</strong>
                                    <div style="background: #f8f9fa; padding: 0.75rem; border-radius: 6px; margin-top: 0.5rem; font-size: 0.875rem; line-height: 1.5;">
                                        ${submission.content}
                                    </div>
                                </div>
                            ` : ''}
                            
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                ${submission.file_path ? `
                                    <a href="/storage/${submission.file_path}" target="_blank" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="las la-download"></i> Download File
                                    </a>
                                ` : ''}
                                
                                ${!submission.grade ? `
                                    <button onclick="gradeSubmission(${submission.id})" style="background: var(--primary-gold); color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="las la-star"></i> Grade This
                                    </button>
                                ` : `
                                    <div style="color: var(--success-green); font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="las la-check-circle"></i> Already graded
                                    </div>
                                `}
                            </div>
                        </div>
                    `;
                });
                
                html += '</div>';
                content.innerHTML = html;
            } else {
                content.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-secondary);">No submissions found for this task.</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--error-red);">Error loading submissions. Please try again.</div>';
        });
}

function closeSubmissionsModal() {
    document.getElementById('submissionsModal').style.display = 'none';
}

function gradeSubmission(submissionId) {
    // This will be implemented later for grading functionality
    alert('Grading functionality will be implemented soon!');
}

// Close modal when clicking outside
document.getElementById('submissionsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSubmissionsModal();
    }
});
</script>
@endsection