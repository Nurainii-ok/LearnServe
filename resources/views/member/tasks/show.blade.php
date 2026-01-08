@extends('layouts.member')

@section('title', $task->title)

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('member.tasks.index') }}">Tasks</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($task->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Task Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h2 class="h4 mb-3 fw-bold">{{ $task->title }}</h2>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge rounded-pill px-3 py-2
                                    @if($task->priority === 'high') bg-danger bg-opacity-10 text-danger
                                    @elseif($task->priority === 'medium') bg-warning bg-opacity-10 text-warning
                                    @else bg-success bg-opacity-10 text-success
                                    @endif">
                                    <i class="las la-flag"></i> {{ ucfirst($task->priority) }} Priority
                                </span>
                                @if($task->is_overdue && !$submission)
                                    <span class="badge rounded-pill px-3 py-2 bg-danger bg-opacity-10 text-danger">
                                        <i class="las la-clock"></i> Overdue
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="text-muted text-uppercase small fw-semibold mb-3">Description</h6>
                        <p class="text-secondary mb-0">{{ $task->description }}</p>
                    </div>
                    
                    <!-- Instructions -->
                    @if($task->instructions)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-3">Instructions</h6>
                            <div class="alert alert-info border-0 bg-info bg-opacity-10">
                                <i class="las la-info-circle text-info"></i>
                                <span class="ms-2">{{ $task->instructions }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Attachments -->
                    @if($task->attachments && count($task->attachments) > 0)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-3">Task Attachments</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($task->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                       class="btn btn-outline-primary btn-sm rounded-pill" target="_blank">
                                        <i class="las la-paperclip"></i> {{ $attachment['original_name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Submission Section -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        @if($submission)
                            <i class="las la-check-circle text-success"></i> My Submission
                        @else
                            <i class="las la-file-upload"></i> Submit Your Work
                        @endif
                    </h5>

                    @if(session('success'))
                        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success alert-dismissible fade show" role="alert">
                            <i class="las la-check-circle"></i>
                            <span class="ms-2">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($submission)
                        <!-- Existing Submission -->
                        @if($submission->content)
                            <div class="mb-4">
                                <h6 class="text-muted text-uppercase small fw-semibold mb-3">Submitted Content</h6>
                                <div class="border rounded-3 p-4 bg-light">
                                    <p class="mb-0">{{ $submission->content }}</p>
                                </div>
                            </div>
                        @endif

                        @if($submission->file_path)
                            <div class="mb-4">
                                <h6 class="text-muted text-uppercase small fw-semibold mb-3">Submitted File</h6>
                                <a href="{{ $submission->file_url }}" class="btn btn-outline-primary rounded-pill" target="_blank">
                                    <i class="las la-download"></i> {{ $submission->original_filename }}
                                </a>
                            </div>
                        @endif

                        @if($submission->is_graded)
                            <div class="mb-4">
                                <h6 class="text-muted text-uppercase small fw-semibold mb-3">Grade & Feedback</h6>
                                <div class="alert border-0 bg-success bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <strong class="text-success">Your Grade</strong>
                                        <span class="badge bg-success fs-5 px-3 py-2">
                                            {{ $submission->grade }}/100 ({{ $submission->grade_letter }})
                                        </span>
                                    </div>
                                    @if($submission->feedback)
                                        <div class="mt-3 pt-3 border-top border-success border-opacity-25">
                                            <strong class="text-success d-block mb-2">Teacher's Feedback</strong>
                                            <p class="mb-0 text-secondary">{{ $submission->feedback }}</p>
                                        </div>
                                    @endif
                                    <small class="text-muted d-block mt-3">
                                        <i class="las la-clock"></i>
                                        Graded on {{ optional($submission->graded_at)->format('M d, Y H:i') ?? 'N/A' }}
                                        by {{ $submission->gradedBy->name ?? 'Unknown' }}

                                    </small>
                                </div>
                            </div>
                        @endif

                        @if(!$submission->is_graded)
                            <button type="button" class="btn btn-primary rounded-pill px-4" 
                                    data-bs-toggle="modal" data-bs-target="#resubmitModal">
                                <i class="las la-edit"></i> Update Submission
                            </button>
                        @endif
                    @else
                        <!-- Submission Form -->
                        <form action="{{ route('member.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="form-label fw-semibold">Your Answer/Response</label>
                                <textarea class="form-control border-2 @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="8" 
                                          placeholder="Write your response here..."
                                          style="resize: vertical;">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="file" class="form-label fw-semibold">Upload File (Optional)</label>
                                <input type="file" class="form-control border-2 @error('file') is-invalid @enderror" 
                                       id="file" name="file" 
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip">
                                <div class="form-text">
                                    <i class="las la-info-circle"></i>
                                    Supported: PDF, DOC, PPT, Images, ZIP. Max: 10MB
                                </div>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($task->is_overdue)
                                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 mb-4">
                                    <i class="las la-exclamation-triangle text-warning"></i>
                                    <span class="ms-2">This task is overdue, but you can still submit it.</span>
                                </div>
                            @endif

                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('member.tasks.index') }}" class="btn btn-light rounded-pill px-4">
                                    <i class="las la-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="las la-paper-plane"></i> Submit Task
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Task Info Card -->
            <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small fw-semibold mb-4">Task Information</h6>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="las la-school fs-5 text-primary me-2"></i>
                            <small class="text-muted">Class</small>
                        </div>
                        <p class="mb-0 fw-semibold">{{ $task->class->title }}</p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="las la-user fs-5 text-primary me-2"></i>
                            <small class="text-muted">Assigned By</small>
                        </div>
                        <p class="mb-0 fw-semibold">{{ $task->assignedBy->name }}</p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="las la-calendar fs-5 text-primary me-2"></i>
                            <small class="text-muted">Due Date</small>
                        </div>
                        <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-primary' }} bg-opacity-10 
                                           {{ $task->is_overdue ? 'text-danger' : 'text-primary' }} 
                                           fs-6 px-3 py-2 fw-normal">
                            {{ $task->due_date->format('M d, Y H:i') }}
                        </span>
                        @if($task->is_overdue)
                            <div class="mt-2">
                                <small class="text-danger">
                                    <i class="las la-exclamation-triangle"></i> 
                                    This task is overdue
                                </small>
                            </div>
                        @endif
                    </div>

                    @if($submission)
                        <hr class="my-4">
                        <h6 class="text-muted text-uppercase small fw-semibold mb-4">Submission Status</h6>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="las la-clock fs-5 text-primary me-2"></i>
                                <small class="text-muted">Submitted On</small>
                            </div>
                            <p class="mb-0 fw-semibold">{{ $submission->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="las la-info-circle fs-5 text-primary me-2"></i>
                                <small class="text-muted">Status</small>
                            </div>
                            @if($submission->is_graded)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                    <i class="las la-check-circle"></i> Graded
                                </span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                    <i class="las la-hourglass-half"></i> Pending Grade
                                </span>
                            @endif
                            @if($submission->is_late)
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 ms-1">
                                    <i class="las la-exclamation"></i> Late
                                </span>
                            @endif
                        </div>
                    @else
                        <hr class="my-4">
                        <h6 class="text-muted text-uppercase small fw-semibold mb-3">Guidelines</h6>
                        <ul class="list-unstyled small text-secondary">
                            <li class="mb-2"><i class="las la-check text-success"></i> Read the description carefully</li>
                            <li class="mb-2"><i class="las la-check text-success"></i> Follow all instructions</li>
                            <li class="mb-2"><i class="las la-check text-success"></i> Submit text, file, or both</li>
                            <li class="mb-2"><i class="las la-check text-success"></i> Update before grading</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resubmit Modal -->
@if($submission && !$submission->is_graded)
<div class="modal fade" id="resubmitModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('member.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Update Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="alert alert-info border-0 bg-info bg-opacity-10">
                        <i class="las la-info-circle text-info"></i>
                        <span class="ms-2">Updating will replace your previous work and reset any pending grades.</span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="modal_content" class="form-label fw-semibold">Your Answer/Response</label>
                        <textarea class="form-control border-2" id="modal_content" name="content" rows="8" 
                                  style="resize: vertical;">{{ $submission->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="modal_file" class="form-label fw-semibold">Upload New File (Optional)</label>
                        <input type="file" class="form-control border-2" id="modal_file" name="file" 
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip">
                        <div class="form-text">
                            <i class="las la-info-circle"></i>
                            Leave empty to keep current file. Upload new to replace.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="las la-check"></i> Update Submission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection