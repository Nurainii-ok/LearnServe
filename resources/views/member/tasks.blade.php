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

.task-submission {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.submission-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.submission-header h5 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1rem;
    font-weight: 600;
}

.submission-form {
    display: none;
}

.submission-form.active {
    display: block;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
}

.file-upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 6px;
    padding: 2rem;
    text-align: center;
    background: white;
    transition: all 0.2s ease;
    cursor: pointer;
}

.file-upload-zone:hover {
    border-color: var(--primary-brown);
    background: var(--light-cream);
}

.file-upload-zone.dragover {
    border-color: var(--success-green);
    background: rgba(16, 185, 129, 0.05);
}

.upload-icon {
    font-size: 2rem;
    color: var(--primary-gold);
    margin-bottom: 0.5rem;
}

.btn-submit {
    background: var(--primary-brown);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-submit:hover {
    background: var(--deep-brown);
    transform: translateY(-1px);
}

.btn-submit:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
}

.btn-toggle {
    background: transparent;
    border: 1px solid var(--primary-brown);
    color: var(--primary-brown);
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-toggle:hover {
    background: var(--primary-brown);
    color: white;
}

.submission-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
}

.submission-submitted {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.submission-graded {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info-blue);
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.grade-display {
    font-weight: 600;
    font-size: 1.1rem;
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
                <div class="task-submission">
                    <div class="submission-header">
                        <i class="bx bx-upload"></i>
                        <h5>Submit Assignment</h5>
                        @php
                            $submission = $task->submissions->first();
                        @endphp
                        
                        @if(!$submission)
                            <button type="button" class="btn-toggle ms-auto" onclick="toggleSubmissionForm({{ $task->id }})">
                                Submit Work
                            </button>
                        @endif
                    </div>

                    @if($submission)
                        <!-- Show existing submission -->
                        <div class="submission-status {{ $submission->grade ? 'submission-graded' : 'submission-submitted' }}">
                            @if($submission->grade)
                                <i class="bx bx-check-circle"></i>
                                <span>Graded - Score: <span class="grade-display">{{ $submission->grade }}/100</span></span>
                                @if($submission->feedback)
                                    <div class="mt-2">
                                        <strong>Feedback:</strong> {{ $submission->feedback }}
                                    </div>
                                @endif
                            @else
                                <i class="bx bx-time"></i>
                                <span>Submitted on {{ $submission->created_at->format('M d, Y H:i') }} - Waiting for review</span>
                            @endif
                        </div>
                        
                        @if($submission->file_path)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-decoration-none">
                                    <i class="bx bx-download"></i> View Submitted File
                                </a>
                            </div>
                        @endif
                        
                        @if($submission->content)
                            <div class="mt-2">
                                <strong>Submitted Text:</strong>
                                <div class="bg-light p-2 rounded mt-1">{{ $submission->content }}</div>
                            </div>
                        @endif
                    @else
                        <!-- Submission Form -->
                        <form class="submission-form" id="submission-form-{{ $task->id }}" action="{{ route('member.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label class="form-label">Assignment Text/Notes (Optional)</label>
                                <textarea class="form-control" name="content" rows="4" placeholder="Write your assignment text, notes, or explanation here..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Upload File (Optional)</label>
                                <div class="file-upload-zone" onclick="document.getElementById('file-{{ $task->id }}').click()">
                                    <div class="upload-icon">
                                        <i class="bx bx-cloud-upload"></i>
                                    </div>
                                    <h6>Drop your file here or click to browse</h6>
                                    <p class="text-muted mb-0">Supported formats: PDF, DOC, DOCX, TXT, ZIP (Max: 10MB)</p>
                                    <input type="file" id="file-{{ $task->id }}" name="file" accept=".pdf,.doc,.docx,.txt,.zip" style="display: none;" onchange="updateFileName({{ $task->id }})">
                                </div>
                                <div id="file-name-{{ $task->id }}" class="mt-2 text-muted" style="display: none;"></div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-submit">
                                    <i class="bx bx-send me-1"></i>
                                    Submit Assignment
                                </button>
                                <button type="button" class="btn-toggle" onclick="toggleSubmissionForm({{ $task->id }})">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
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

<script>
function toggleSubmissionForm(taskId) {
    const form = document.getElementById('submission-form-' + taskId);
    form.classList.toggle('active');
}

function updateFileName(taskId) {
    const fileInput = document.getElementById('file-' + taskId);
    const fileNameDiv = document.getElementById('file-name-' + taskId);
    
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        const fileSize = (fileInput.files[0].size / 1024 / 1024).toFixed(2);
        fileNameDiv.innerHTML = `<i class="bx bx-file"></i> ${fileName} (${fileSize} MB)`;
        fileNameDiv.style.display = 'block';
    } else {
        fileNameDiv.style.display = 'none';
    }
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadZones = document.querySelectorAll('.file-upload-zone');
    
    uploadZones.forEach(zone => {
        zone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        zone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const taskId = this.querySelector('input[type="file"]').id.split('-')[1];
                const fileInput = document.getElementById('file-' + taskId);
                fileInput.files = files;
                updateFileName(taskId);
            }
        });
    });
});
</script>
@endsection