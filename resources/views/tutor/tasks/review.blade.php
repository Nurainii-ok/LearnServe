@extends('layouts.tutor')

@section('title', 'Review Task Submission - ' . $submission->task->title)

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tutor.tasks.index') }}">Tasks</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tutor.tasks.submissions', $submission->task->id) }}">Submissions</a></li>
            <li class="breadcrumb-item active">Review</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Task Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="task-icon-review">
                            <i class="las la-file-alt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="h5 mb-2 fw-bold">{{ $submission->task->title }}</h3>
                            <div class="d-flex flex-wrap gap-2">
                                @if($task->bootcamp)
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                        <i class="las la-laptop-code"></i> {{ $task->bootcamp->title }}
                                    </span>
                                @elseif($task->class)
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                        <i class="las la-school"></i> {{ $task->class->title }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                        <i class="las la-book"></i> N/A
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small fw-semibold mb-4">
                        <i class="las la-user-graduate"></i> Student Information
                    </h6>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Full Name</label>
                                <div class="info-value">{{ $submission->user->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Email Address</label>
                                <div class="info-value">{{ $submission->user->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Submitted On</label>
                                <div class="info-value">
                                    {{ $submission->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Submission Status</label>
                                <div class="info-value">
                                    @if($submission->is_late)
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                            <i class="las la-exclamation-triangle"></i> Late Submission
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                            <i class="las la-check-circle"></i> On Time
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small fw-semibold mb-4">
                        <i class="las la-clipboard-list"></i> Task Description
                    </h6>
                    <p class="text-secondary mb-3">{{ $submission->task->description }}</p>
                    
                    @if($submission->task->instructions)
                        <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-0">
                            <div class="d-flex gap-2">
                                <i class="las la-info-circle text-info"></i>
                                <div>
                                    <strong class="d-block mb-2">Instructions:</strong>
                                    <p class="mb-0">{{ $submission->task->instructions }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Submission -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small fw-semibold mb-4">
                        <i class="las la-pencil-alt"></i> Student Submission
                    </h6>
                    
                    @if($submission->content)
                        <div class="submission-box mb-3">
                            <div class="submission-header">
                                <i class="las la-file-alt"></i>
                                <span>Text Response</span>
                            </div>
                            <div class="submission-content">
                                {{ $submission->content }}
                            </div>
                        </div>
                    @endif

                    @if($submission->submission_url)
                        <div class="submission-box mb-3">
                            <div class="submission-header">
                                <i class="las la-link"></i>
                                <span>Submission Link</span>
                            </div>
                            <div class="submission-content">
                                <a href="{{ $submission->submission_url }}" target="_blank" 
                                   class="btn btn-outline-primary rounded-pill">
                                    <i class="las la-external-link-alt"></i> Open Link
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($submission->file_path)
                        <div class="submission-box mb-3">
                            <div class="submission-header">
                                <i class="las la-file-download"></i>
                                <span>Submitted File</span>
                            </div>
                            <div class="submission-content">
                                <a href="{{ asset('storage/' . $submission->file_path) }}" 
                                   class="btn btn-outline-primary rounded-pill" target="_blank">
                                    <i class="las la-download"></i> {{ $submission->original_filename ?? 'Download File' }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($submission->submission_notes)
                        <div class="submission-box">
                            <div class="submission-header">
                                <i class="las la-sticky-note"></i>
                                <span>Student Notes</span>
                            </div>
                            <div class="submission-content">
                                {{ $submission->submission_notes }}
                            </div>
                        </div>
                    @endif

                    @if(!$submission->content && !$submission->submission_url && !$submission->file_path && !$submission->submission_notes)
                        <div class="text-center py-4">
                            <i class="las la-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-0">No submission content available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Review Sidebar -->
        <div class="col-lg-4">
            <!-- Current Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small fw-semibold mb-4">
                        <i class="las la-info-circle"></i> Current Status
                    </h6>
                    
                    <div class="status-item mb-3">
                        <label class="status-label">Review Status</label>
                        <span class="badge rounded-pill px-3 py-2
                            @if($submission->submission_status === 'passed') bg-success bg-opacity-10 text-success
                            @elseif($submission->submission_status === 'revision') bg-warning bg-opacity-10 text-warning
                            @elseif($submission->submission_status === 'failed') bg-danger bg-opacity-10 text-danger
                            @else bg-info bg-opacity-10 text-info
                            @endif">
                            @if($submission->submission_status === 'passed')
                                <i class="las la-check-circle"></i>
                            @elseif($submission->submission_status === 'revision')
                                <i class="las la-redo-alt"></i>
                            @elseif($submission->submission_status === 'failed')
                                <i class="las la-times-circle"></i>
                            @else
                                <i class="las la-clock"></i>
                            @endif
                            {{ ucfirst(str_replace('_', ' ', $submission->submission_status ?? 'pending')) }}
                        </span>
                    </div>
                    
                    @if($submission->grade)
                        <div class="status-item">
                            <label class="status-label">Current Grade</label>
                            <div class="grade-display
                                @if($submission->grade >= 90) grade-excellent
                                @elseif($submission->grade >= 80) grade-good
                                @elseif($submission->grade >= 70) grade-fair
                                @else grade-poor
                                @endif">
                                <span class="grade-value">{{ $submission->grade }}</span>
                                <span class="grade-max">/100</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Review Form Card -->
            <div class="card border-0 shadow-sm sticky-sidebar">
                <div class="card-header bg-white border-0 p-4">
                    <h6 class="mb-0 fw-bold">
                        <i class="las la-edit text-primary"></i>
                        Review & Feedback
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tutor.tasks.submission.submit-review', $submission->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Action Selection -->
                        <div class="mb-4">
                            <label for="action" class="form-label fw-semibold">Action Required *</label>
                            <select class="form-select border-2 @error('action') is-invalid @enderror" 
                                    id="action" name="action" required onchange="updateActionUI()">
                                <option value="">Select Action</option>
                                <option value="pass">✓ Complete (Pass)</option>
                                <option value="revision">↻ Revision Needed</option>
                                <option value="fail">✗ Fail</option>
                            </select>
                            @error('action')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Grade Input -->
                        <div class="mb-4" id="gradeSection" style="display: none;">
                            <label for="grade" class="form-label fw-semibold">Grade (0-100)</label>
                            <input type="number" class="form-control border-2 @error('grade') is-invalid @enderror" 
                                   id="grade" name="grade" min="0" max="100" value="{{ old('grade') }}"
                                   placeholder="Enter grade">
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Feedback Textarea -->
                        <div class="mb-4">
                            <label for="feedback" class="form-label fw-semibold">Feedback *</label>
                            <textarea class="form-control border-2 @error('feedback') is-invalid @enderror" 
                                      id="feedback" name="feedback" rows="6" 
                                      placeholder="Provide detailed feedback for the student..."
                                      required style="resize: vertical;">{{ old('feedback') }}</textarea>
                            <div class="form-text" id="feedbackHint">
                                <i class="las la-lightbulb"></i>
                                <span>Provide constructive feedback</span>
                            </div>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Certificate Upload -->
                        <div class="mb-4" id="certificateSection" style="display: none;">
                            <label for="certificate_file" class="form-label fw-semibold">
                                Certificate File
                                <span class="text-muted fw-normal">(Optional)</span>
                            </label>
                            <input type="file" class="form-control border-2 @error('certificate_file') is-invalid @enderror" 
                                   id="certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text">
                                <i class="las la-info-circle"></i>
                                Upload certificate PDF or image
                            </div>
                            @error('certificate_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4" id="submitBtn">
                                <i class="las la-check"></i> Submit Review
                            </button>
                            <a href="{{ route('tutor.tasks.submissions', $submission->task->id) }}" 
                               class="btn btn-light rounded-pill px-4">
                                <i class="las la-arrow-left"></i> Back to Submissions
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Task Icon */
.task-icon-review {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.task-icon-review i {
    font-size: 1.75rem;
    color: white;
}

/* Info Items */
.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

.info-value {
    font-size: 0.9375rem;
    color: #111827;
    font-weight: 500;
}

/* Submission Boxes */
.submission-box {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.submission-box:hover {
    border-color: #d1d5db;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.submission-header {
    background: #f9fafb;
    padding: 0.875rem 1.25rem;
    border-bottom: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
}

.submission-header i {
    font-size: 1.25rem;
    color: #6b7280;
}

.submission-content {
    padding: 1.25rem;
    background: white;
    color: #374151;
    line-height: 1.6;
}

/* Status Items */
.status-item {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.status-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

/* Grade Display */
.grade-display {
    display: inline-flex;
    align-items: baseline;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
}

.grade-value {
    font-size: 1.5rem;
}

.grade-max {
    font-size: 1rem;
    opacity: 0.7;
    margin-left: 2px;
}

.grade-excellent {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.grade-good {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.grade-fair {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.grade-poor {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

/* Sticky Sidebar */
.sticky-sidebar {
    position: sticky;
    top: 90px;
}

/* Form Enhancements */
.form-select:focus,
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Feedback Hint */
#feedbackHint {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

#feedbackHint i {
    font-size: 1rem;
}

/* Button Transitions */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Card Hover Effects */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .sticky-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .task-icon-review {
        width: 48px;
        height: 48px;
    }
    
    .task-icon-review i {
        font-size: 1.5rem;
    }
    
    .submission-header {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .submission-content {
        padding: 1rem;
        font-size: 0.875rem;
    }
    
    .grade-display {
        padding: 0.5rem 1rem;
    }
    
    .grade-value {
        font-size: 1.25rem;
    }
}
</style>

<script>
function updateActionUI() {
    const action = document.getElementById('action').value;
    const gradeSection = document.getElementById('gradeSection');
    const certificateSection = document.getElementById('certificateSection');
    const feedbackHint = document.getElementById('feedbackHint');
    const submitBtn = document.getElementById('submitBtn');

    // Reset visibility
    gradeSection.style.display = 'none';
    certificateSection.style.display = 'none';

    if (action === 'pass') {
        gradeSection.style.display = 'block';
        certificateSection.style.display = 'block';
        feedbackHint.innerHTML = '<i class="las la-lightbulb"></i><span>Provide positive feedback and congratulations</span>';
        submitBtn.innerHTML = '<i class="las la-check-circle"></i> Mark as Complete';
        submitBtn.className = 'btn btn-success rounded-pill px-4';
    } else if (action === 'revision') {
        feedbackHint.innerHTML = '<i class="las la-lightbulb"></i><span>Explain what needs to be revised and provide guidance</span>';
        submitBtn.innerHTML = '<i class="las la-redo-alt"></i> Request Revision';
        submitBtn.className = 'btn btn-warning rounded-pill px-4';
    } else if (action === 'fail') {
        gradeSection.style.display = 'block';
        feedbackHint.innerHTML = '<i class="las la-lightbulb"></i><span>Explain why the submission failed and what to improve</span>';
        submitBtn.innerHTML = '<i class="las la-times-circle"></i> Mark as Failed';
        submitBtn.className = 'btn btn-danger rounded-pill px-4';
    } else {
        feedbackHint.innerHTML = '<i class="las la-lightbulb"></i><span>Provide constructive feedback</span>';
        submitBtn.innerHTML = '<i class="las la-check"></i> Submit Review';
        submitBtn.className = 'btn btn-primary rounded-pill px-4';
    }
}
</script>
@endsection