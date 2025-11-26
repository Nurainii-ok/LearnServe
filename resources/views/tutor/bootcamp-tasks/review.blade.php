 @extends('layouts.tutor')

@section('title', 'Review Task Submission - ' . $submission->task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Submission Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">{{ $submission->task->title }}</h4>
                    <p class="text-muted mb-0">Bootcamp: {{ $submission->task->bootcamp->title }}</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Student Info -->
                            <div class="mb-4">
                                <h6 class="mb-3">Student Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> {{ $submission->user->name }}</p>
                                        <p><strong>Email:</strong> {{ $submission->user->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Submitted:</strong> {{ $submission->created_at->format('M d, Y H:i') }}</p>
                                        @if($submission->is_late)
                                            <p><span class="badge bg-warning">Late Submission</span></p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Task Description -->
                            <div class="mb-4">
                                <h6 class="mb-2">Task Description</h6>
                                <p>{{ $submission->task->description }}</p>
                                @if($submission->task->instructions)
                                    <p><strong>Instructions:</strong></p>
                                    <p>{{ $submission->task->instructions }}</p>
                                @endif
                            </div>

                            <!-- Student Submission -->
                            <div class="mb-4">
                                <h6 class="mb-3">Student Submission</h6>
                                
                                @if($submission->content)
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title">Text Response</h6>
                                            <p>{{ $submission->content }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($submission->submission_url)
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title">Submission Link</h6>
                                            <a href="{{ $submission->submission_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-external-link-alt"></i> Open Link
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if($submission->file_path)
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title">Submitted File</h6>
                                            <a href="{{ $submission->file_url }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="las la-download"></i> {{ $submission->original_filename }}
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if($submission->submission_notes)
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Student Notes</h6>
                                            <p>{{ $submission->submission_notes }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Review Panel -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Review & Feedback</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('tutor.bootcamp-tasks.submit-review', $submission->id) }}" method="POST">
                                        @csrf

                                        <!-- Action Selection -->
                                        <div class="mb-3">
                                            <label for="action" class="form-label">Action *</label>
                                            <select class="form-select @error('action') is-invalid @enderror" 
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

                                        <!-- Grade Input (shown for pass/fail) -->
                                        <div class="mb-3" id="gradeSection" style="display: none;">
                                            <label for="grade" class="form-label">Grade (0-100)</label>
                                            <input type="number" class="form-control @error('grade') is-invalid @enderror" 
                                                   id="grade" name="grade" min="0" max="100" value="{{ old('grade') }}">
                                            @error('grade')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Feedback Textarea -->
                                        <div class="mb-3">
                                            <label for="feedback" class="form-label">Feedback *</label>
                                            <textarea class="form-control @error('feedback') is-invalid @enderror" 
                                                      id="feedback" name="feedback" rows="5" 
                                                      placeholder="Provide detailed feedback for the student..."
                                                      required>{{ old('feedback') }}</textarea>
                                            <div class="form-text" id="feedbackHint">
                                                Provide constructive feedback
                                            </div>
                                            @error('feedback')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Certificate Upload (shown for pass) -->
                                        <div class="mb-3" id="certificateSection" style="display: none;">
                                            <label for="certificate_file" class="form-label">Certificate File (Optional)</label>
                                            <input type="file" class="form-control @error('certificate_file') is-invalid @enderror" 
                                                   id="certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                                            <div class="form-text">
                                                Upload certificate PDF or image (optional - will be auto-generated if not provided)
                                            </div>
                                            @error('certificate_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                                <i class="las la-check"></i> Submit Review
                                            </button>
                                            <a href="{{ route('tutor.bootcamp-tasks.submissions', $submission->task->bootcamp_id) }}" 
                                               class="btn btn-secondary">
                                                <i class="las la-arrow-left"></i> Back
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Status Info -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">Current Status</h6>
                                    <p class="mb-1">
                                        <strong>Status:</strong>
                                        <span class="badge 
                                            @if($submission->status === 'passed') bg-success
                                            @elseif($submission->status === 'revision') bg-warning
                                            @elseif($submission->status === 'failed') bg-danger
                                            @else bg-info
                                            @endif">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </p>
                                    @if($submission->grade)
                                        <p class="mb-0">
                                            <strong>Grade:</strong>
                                            <span class="badge 
                                                @if($submission->grade >= 90) bg-success
                                                @elseif($submission->grade >= 80) bg-info
                                                @elseif($submission->grade >= 70) bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $submission->grade }}/100
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        feedbackHint.textContent = 'Provide positive feedback and congratulations';
        submitBtn.innerHTML = '<i class="las la-check"></i> Mark as Complete';
        submitBtn.className = 'btn btn-success';
    } else if (action === 'revision') {
        feedbackHint.textContent = 'Explain what needs to be revised and provide guidance';
        submitBtn.innerHTML = '<i class="las la-redo"></i> Request Revision';
        submitBtn.className = 'btn btn-warning';
    } else if (action === 'fail') {
        gradeSection.style.display = 'block';
        feedbackHint.textContent = 'Explain why the submission failed and what to improve';
        submitBtn.innerHTML = '<i class="las la-times"></i> Mark as Failed';
        submitBtn.className = 'btn btn-danger';
    }
}
</script>
@endsection