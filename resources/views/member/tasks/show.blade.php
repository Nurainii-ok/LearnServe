@extends('layouts.member')

@section('title', $task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Task Details Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $task->title }}</h4>
                    <div>
                        <span class="badge 
                            @if($task->priority === 'high') bg-danger
                            @elseif($task->priority === 'medium') bg-warning
                            @else bg-success
                            @endif">
                            {{ ucfirst($task->priority) }} Priority
                        </span>
                        @if($task->is_overdue && !$submission)
                            <span class="badge bg-danger ms-1">Overdue</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h6>Description:</h6>
                                <p>{{ $task->description }}</p>
                            </div>
                            
                            @if($task->instructions)
                                <div class="mb-3">
                                    <h6>Instructions:</h6>
                                    <div class="alert alert-info">
                                        {{ $task->instructions }}
                                    </div>
                                </div>
                            @endif

                            @if($task->attachments && count($task->attachments) > 0)
                                <div class="mb-3">
                                    <h6>Task Attachments:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($task->attachments as $attachment)
                                            <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                               class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="las la-download"></i> {{ $attachment['original_name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Task Information</h6>
                                    <p class="mb-2"><strong>Class:</strong> {{ $task->class->title }}</p>
                                    <p class="mb-2"><strong>Assigned by:</strong> {{ $task->assignedBy->name }}</p>
                                    <p class="mb-2"><strong>Due Date:</strong></p>
                                    <p class="mb-0">
                                        <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }} fs-6">
                                            {{ $task->due_date->format('M d, Y H:i') }}
                                        </span>
                                    </p>
                                    @if($task->is_overdue)
                                        <small class="text-danger">
                                            <i class="las la-exclamation-triangle"></i> 
                                            This task is overdue
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submission Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        @if($submission)
                            My Submission
                        @else
                            Submit Your Work
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($submission)
                        <!-- Show existing submission -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <h6>Submitted Content:</h6>
                                    @if($submission->content)
                                        <div class="border p-3 bg-light rounded">
                                            {{ $submission->content }}
                                        </div>
                                    @else
                                        <p class="text-muted">No text content submitted.</p>
                                    @endif
                                </div>

                                @if($submission->file_path)
                                    <div class="mb-3">
                                        <h6>Submitted File:</h6>
                                        <a href="{{ $submission->file_url }}" class="btn btn-outline-primary" target="_blank">
                                            <i class="las la-download"></i> {{ $submission->original_filename }}
                                        </a>
                                    </div>
                                @endif

                                @if($submission->is_graded)
                                    <div class="mb-3">
                                        <h6>Grade & Feedback:</h6>
                                        <div class="alert alert-success">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Grade:</strong>
                                                <span class="badge bg-success fs-6">
                                                    {{ $submission->grade }}/100 ({{ $submission->grade_letter }})
                                                </span>
                                            </div>
                                            @if($submission->feedback)
                                                <div class="mt-2">
                                                    <strong>Feedback:</strong>
                                                    <p class="mb-0 mt-1">{{ $submission->feedback }}</p>
                                                </div>
                                            @endif
                                            <small class="text-muted">
                                                Graded on {{ $submission->graded_at->format('M d, Y H:i') }} 
                                                by {{ $submission->gradedBy->name }}
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Submission Status</h6>
                                        <p class="mb-2">
                                            <strong>Submitted:</strong><br>
                                            {{ $submission->created_at->format('M d, Y H:i') }}
                                        </p>
                                        @if($submission->is_late)
                                            <p class="mb-2">
                                                <span class="badge bg-warning">Late Submission</span>
                                            </p>
                                        @endif
                                        <p class="mb-2">
                                            <strong>Status:</strong><br>
                                            @if($submission->is_graded)
                                                <span class="badge bg-success">Graded</span>
                                            @else
                                                <span class="badge bg-warning">Pending Grade</span>
                                            @endif
                                        </p>
                                        
                                        @if(!$submission->is_graded)
                                            <button type="button" class="btn btn-primary btn-sm w-100" 
                                                    data-bs-toggle="modal" data-bs-target="#resubmitModal">
                                                <i class="las la-edit"></i> Update Submission
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Submission form -->
                        <form action="{{ route('member.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Your Answer/Response</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                  id="content" name="content" rows="6" 
                                                  placeholder="Write your response here...">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="file" class="form-label">Upload File (Optional)</label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                               id="file" name="file" 
                                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip">
                                        <div class="form-text">
                                            Supported formats: PDF, DOC, PPT, Images, ZIP. Max size: 10MB
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Submission Guidelines</h6>
                                            <ul class="small mb-3">
                                                <li>Read the task description carefully</li>
                                                <li>Follow the instructions provided</li>
                                                <li>You can submit text, file, or both</li>
                                                <li>You can update your submission until graded</li>
                                            </ul>
                                            
                                            @if($task->is_overdue)
                                                <div class="alert alert-warning small">
                                                    <i class="las la-exclamation-triangle"></i>
                                                    This task is overdue, but you can still submit it.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('member.tasks.index') }}" class="btn btn-secondary">
                                    <i class="las la-arrow-left"></i> Back to Tasks
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="las la-paper-plane"></i> Submit Task
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resubmit Modal -->
@if($submission && !$submission->is_graded)
<div class="modal fade" id="resubmitModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('member.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Update Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="las la-info-circle"></i>
                        Updating your submission will replace your previous work and reset any pending grades.
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal_content" class="form-label">Your Answer/Response</label>
                        <textarea class="form-control" id="modal_content" name="content" rows="6">{{ $submission->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="modal_file" class="form-label">Upload New File (Optional)</label>
                        <input type="file" class="form-control" id="modal_file" name="file" 
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip">
                        <div class="form-text">
                            Leave empty to keep current file. Upload new file to replace.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Submission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="d-flex justify-content-start mt-3">
    <a href="{{ route('member.tasks.index') }}" class="btn btn-secondary">
        <i class="las la-arrow-left"></i> Back to Tasks
    </a>
</div>
@endsection