@extends('layouts.member')

@section('title', 'My Tasks')

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
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
}

.page-header {
    background: white;
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.page-header p {
    color: #6b7280;
    margin: 0;
    font-size: 1rem;
}

.task-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    position: relative;
    overflow: hidden;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.task-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}

.task-card.pending::before { background: var(--warning-yellow); }
.task-card.in-progress::before { background: var(--info-blue); }
.task-card.completed::before { background: var(--success-green); }
.task-card.overdue::before { background: var(--error-red); }

.task-header {
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.task-content {
    padding: 0 1.5rem 1.5rem 1.5rem;
}

.task-info h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.class-name {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0 0 0.75rem 0;
}

.task-description {
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0 0 1rem 0;
}

.task-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.meta-item i {
    color: var(--primary-gold);
}

.task-status {
    text-align: right;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: inline-block;
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-yellow);
}

.status-in-progress {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info-blue);
}

.status-completed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.status-overdue {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.due-date {
    font-size: 0.875rem;
    font-weight: 500;
}

.due-date.overdue {
    color: var(--error-red);
}

.due-date.soon {
    color: var(--warning-yellow);
}

.due-date.normal {
    color: var(--text-secondary);
}

.priority-badge {
    padding: 0.25rem 0.5rem;
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
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-yellow);
}

.priority-low {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.instructions-section {
    background: var(--light-cream);
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.instructions-section h5 {
    margin: 0 0 0.5rem 0;
    color: var(--primary-brown);
    font-size: 1rem;
}

.instructions-text {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.5;
}

.empty-state {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
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
}

.empty-state p {
    color: var(--text-secondary);
    margin: 0 0 2rem 0;
}

.btn-browse {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-browse:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.task-filters {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.filter-tabs {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 0.5rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: white;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.filter-tab:hover {
    border-color: var(--primary-gold);
    color: var(--text-primary);
    text-decoration: none;
}

.filter-tab.active {
    background: var(--primary-brown);
    border-color: var(--primary-brown);
    color: white;
}

/* Task Submission Styles */
.task-submission {
    margin-top: 1.5rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.task-submission h5 {
    margin: 0 0 1rem 0;
    color: var(--primary-brown);
    font-size: 1rem;
    font-weight: 600;
}

.submission-form .form-group {
    margin-bottom: 1rem;
}

.submission-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.875rem;
}

.submission-form .form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s ease;
    background: white;
}

.submission-form .form-control:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
}

.file-upload-wrapper {
    position: relative;
}

.file-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.file-upload-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: 2px dashed #d1d5db;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.file-upload-label:hover {
    border-color: var(--primary-brown);
    color: var(--primary-brown);
}

.file-upload-label i {
    font-size: 1.25rem;
}

.file-info {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: var(--success-green);
}

.file-hint {
    color: var(--text-secondary);
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
}

.submission-actions {
    margin-top: 1.5rem;
    text-align: right;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--success-green);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-submit:hover {
    background: #059669;
    transform: translateY(-1px);
}

.btn-submit i {
    font-size: 1rem;
}

.task-completed {
    margin-top: 1.5rem;
    padding: 1rem;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 6px;
}

.completed-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--success-green);
    font-weight: 500;
}

.completed-message i {
    font-size: 1.25rem;
}

@media (max-width: 768px) {
    .task-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .task-status {
        text-align: left;
    }
    
    .task-meta {
        justify-content: flex-start;
    }
    
    .filter-tabs {
        justify-content: center;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <div class="page-header">
        <h1>My Tasks</h1>
        <p>Keep track of assignments and deadlines from your enrolled classes</p>
    </div>

    @if($tasks->count() > 0)
        <!-- Task Filters -->
        <div class="task-filters">
            <div class="filter-tabs">
                <a href="{{ route('member.tasks') }}" class="filter-tab active">All Tasks</a>
                <a href="{{ route('member.tasks') }}?status=pending" class="filter-tab">Pending</a>
                <a href="{{ route('member.tasks') }}?status=in_progress" class="filter-tab">In Progress</a>
                <a href="{{ route('member.tasks') }}?status=completed" class="filter-tab">Completed</a>
                <a href="{{ route('member.tasks') }}?status=overdue" class="filter-tab">Overdue</a>
            </div>
        </div>

        <!-- Tasks List -->
        @foreach($tasks as $task)
        @php
            $now = now();
            $dueDate = $task->due_date;
            $daysDiff = $now->diffInDays($dueDate, false);
            
            $dueDateClass = 'normal';
            if ($now->gt($dueDate)) {
                $dueDateClass = 'overdue';
                $taskStatus = 'overdue';
            } elseif ($daysDiff <= 2) {
                $dueDateClass = 'soon';
            }
            
            $taskStatus = $task->status;
            if ($now->gt($dueDate) && $task->status !== 'completed') {
                $taskStatus = 'overdue';
            }
        @endphp
        <div class="task-card {{ $taskStatus }}">
            <div class="task-header">
                <div class="task-info">
                    <h3>{{ $task->title }}</h3>
                    <p class="class-name">{{ $task->class->title ?? 'Class Name' }}</p>
                    <div class="task-meta">
                        @if($task->assignedBy)
                        <div class="meta-item">
                            <i class="bx bx-user"></i>
                            <span>Assigned by {{ $task->assignedBy->name }}</span>
                        </div>
                        @endif
                        <div class="meta-item">
                            <i class="bx bx-calendar-plus"></i>
                            <span>Created {{ $task->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($task->priority)
                        <div class="meta-item">
                            <i class="bx bx-flag"></i>
                            <span>Priority</span>
                            <span class="priority-badge priority-{{ $task->priority }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="task-status">
                    <span class="status-badge status-{{ $taskStatus }}">
                        @switch($taskStatus)
                            @case('pending')
                                📋 Pending
                                @break
                            @case('in_progress')
                                🔄 In Progress
                                @break
                            @case('completed')
                                ✅ Completed
                                @break
                            @case('overdue')
                                ⚠️ Overdue
                                @break
                            @default
                                📋 Pending
                        @endswitch
                    </span>
                    <div class="due-date {{ $dueDateClass }}">
                        @if($now->gt($dueDate))
                            Overdue by {{ $now->diffForHumans($dueDate, true) }}
                        @else
                            Due {{ $dueDate->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="task-content">
                @if($task->description)
                <p class="task-description">{{ $task->description }}</p>
                @endif
                
                @if($task->instructions)
                <div class="instructions-section">
                    <h5>Instructions</h5>
                    <p class="instructions-text">{{ $task->instructions }}</p>
                </div>
                @endif
                
                <!-- Task Submission Section -->
                @php
                    $userSubmission = $task->submissions->where('user_id', session('user_id'))->first();
                @endphp
                
                @if($userSubmission)
                <div class="task-submitted">
                    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 8px; padding: 1.5rem; margin-top: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <i class="bx bx-check-circle" style="font-size: 1.5rem; color: var(--success-green);"></i>
                            <div>
                                <h5 style="margin: 0; color: var(--success-green);">Task Submitted</h5>
                                <p style="margin: 0; color: var(--text-secondary); font-size: 0.875rem;">
                                    Submitted on {{ $userSubmission->created_at->format('M d, Y \a\t H:i') }}
                                </p>
                            </div>
                        </div>
                        
                        @if($userSubmission->content)
                        <div style="margin-bottom: 1rem;">
                            <strong style="color: var(--primary-brown); font-size: 0.875rem;">Your Submission:</strong>
                            <div style="background: white; padding: 0.75rem; border-radius: 6px; margin-top: 0.5rem; font-size: 0.875rem; line-height: 1.5; border: 1px solid #e5e7eb;">
                                {{ $userSubmission->content }}
                            </div>
                        </div>
                        @endif
                        
                        @if($userSubmission->file_path)
                        <div style="margin-bottom: 1rem;">
                            <strong style="color: var(--primary-brown); font-size: 0.875rem;">Attached File:</strong>
                            <div style="margin-top: 0.5rem;">
                                <a href="{{ asset('storage/' . $userSubmission->file_path) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem;">
                                    <i class="bx bx-download"></i>
                                    {{ $userSubmission->original_filename ?: 'Download File' }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($userSubmission->grade)
                        <div style="margin-bottom: 1rem;">
                            <strong style="color: var(--primary-brown); font-size: 0.875rem;">Grade:</strong>
                            <span style="background: var(--success-green); color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 600; margin-left: 0.5rem;">
                                {{ $userSubmission->grade }}%
                            </span>
                            @if($userSubmission->feedback)
                            <div style="background: white; padding: 0.75rem; border-radius: 6px; margin-top: 0.5rem; font-size: 0.875rem; line-height: 1.5; border: 1px solid #e5e7eb;">
                                <strong>Feedback:</strong> {{ $userSubmission->feedback }}
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        <div style="text-align: center;">
                            <button onclick="showResubmitForm({{ $task->id }})" style="background: var(--primary-gold); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; font-size: 0.875rem; cursor: pointer;">
                                <i class="bx bx-edit"></i> Update Submission
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Resubmit Form (Hidden by default) -->
                <div id="resubmit-form-{{ $task->id }}" style="display: none; margin-top: 1rem;">
                    <div class="task-submission">
                        <h5>Update Your Submission</h5>
                        <form action="{{ route('member.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data" class="submission-form">
                @elseif($taskStatus !== 'completed')
                <div class="task-submission">
                    <h5>Submit Your Work</h5>
                    <form action="{{ route('member.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data" class="submission-form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="submission_text_{{ $task->id }}">Description/Notes</label>
                            <textarea 
                                id="submission_text_{{ $task->id }}" 
                                name="submission_text" 
                                class="form-control" 
                                rows="3" 
                                placeholder="Describe your work or add any notes..."
                            ></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="submission_file_{{ $task->id }}">Upload File (Optional)</label>
                            <div class="file-upload-wrapper">
                                <input 
                                    type="file" 
                                    id="submission_file_{{ $task->id }}" 
                                    name="submission_file" 
                                    class="file-input"
                                    accept=".pdf,.doc,.docx,.txt,.zip,.rar,.jpg,.jpeg,.png"
                                >
                                <label for="submission_file_{{ $task->id }}" class="file-upload-label">
                                    <i class="bx bx-cloud-upload"></i>
                                    <span>Choose File</span>
                                </label>
                                <div class="file-info"></div>
                            </div>
                            <small class="file-hint">Supported: PDF, DOC, TXT, ZIP, Images (Max: 10MB)</small>
                        </div>
                        
                        <div class="submission-actions">
                            <button type="submit" class="btn-submit">
                                <i class="bx bx-check"></i>
                                Submit Task
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="task-completed">
                    <div class="completed-message">
                        <i class="bx bx-check-circle"></i>
                        <span>Task completed successfully!</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        @if($tasks->hasPages())
        <div class="pagination-wrapper">
            {{ $tasks->links() }}
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="bx bx-task"></i>
            <h3>No Tasks Yet</h3>
            <p>You don't have any tasks assigned yet. Enroll in classes to start receiving assignments!</p>
            <a href="{{ route('learning') }}" class="btn-browse">Browse Classes</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle file upload display
    const fileInputs = document.querySelectorAll('.file-input');
    
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const fileInfo = this.parentElement.querySelector('.file-info');
            const label = this.parentElement.querySelector('.file-upload-label span');
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                
                if (file.size > 10 * 1024 * 1024) { // 10MB limit
                    alert('File size must be less than 10MB');
                    this.value = '';
                    fileInfo.textContent = '';
                    label.textContent = 'Choose File';
                    return;
                }
                
                fileInfo.textContent = `Selected: ${file.name} (${fileSize} MB)`;
                label.textContent = file.name;
            } else {
                fileInfo.textContent = '';
                label.textContent = 'Choose File';
            }
        });
    });
    
    // Handle form submission
    const submissionForms = document.querySelectorAll('.submission-form');
    
    submissionForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const textarea = form.querySelector('textarea');
            const fileInput = form.querySelector('.file-input');
            
            // Check if at least one field is filled
            if (!textarea.value.trim() && (!fileInput.files || !fileInput.files[0])) {
                e.preventDefault();
                alert('Please provide either a description or upload a file to submit your task.');
                return;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Submitting...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds (in case of error)
            setTimeout(function() {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    });
});

function showResubmitForm(taskId) {
    const form = document.getElementById(`resubmit-form-${taskId}`);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>
@endsection