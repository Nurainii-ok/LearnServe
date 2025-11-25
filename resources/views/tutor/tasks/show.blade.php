@extends('layouts.tutor')

@section('title', 'Task Submissions - ' . $task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Task Details Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">{{ $task->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-2"><strong>Description:</strong></p>
                            <p>{{ $task->description }}</p>
                            
                            @if($task->instructions)
                                <p class="mb-2"><strong>Instructions:</strong></p>
                                <p>{{ $task->instructions }}</p>
                            @endif

                            @if($task->attachments && count($task->attachments) > 0)
                                <p class="mb-2"><strong>Attachments:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($task->attachments as $attachment)
                                        <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                           class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="las la-download"></i> {{ $attachment['original_name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Task Details</h6>
                                    <p class="mb-1"><strong>Class:</strong> {{ $task->class->title }}</p>
                                    <p class="mb-1"><strong>Due Date:</strong> 
                                        <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }}">
                                            {{ $task->due_date->format('M d, Y H:i') }}
                                        </span>
                                    </p>
                                    <p class="mb-1"><strong>Priority:</strong> 
                                        <span class="badge 
                                            @if($task->priority === 'high') bg-danger
                                            @elseif($task->priority === 'medium') bg-warning
                                            @else bg-success
                                            @endif">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </p>
                                    <p class="mb-1"><strong>Submissions:</strong> {{ $submissions->count() }}</p>
                                    <p class="mb-0"><strong>Graded:</strong> {{ $submissions->whereNotNull('grade')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submissions Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Student Submissions</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Submitted</th>
                                        <th>Content</th>
                                        <th>File</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $submission)
                                        <tr>
                                            <td>
                                                <strong>{{ $submission->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $submission->user->email }}</small>
                                            </td>
                                            <td>
                                                {{ $submission->created_at->format('M d, Y H:i') }}
                                                @if($submission->is_late)
                                                    <br><span class="badge bg-warning">Late</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($submission->content)
                                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $submission->content }}">
                                                        {{ Str::limit($submission->content, 100) }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">No text content</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($submission->file_path)
                                                    <a href="{{ $submission->file_url }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="las la-download"></i> {{ $submission->original_filename }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No file</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($submission->is_graded)
                                                    <span class="badge 
                                                        @if($submission->grade >= 90) bg-success
                                                        @elseif($submission->grade >= 80) bg-info
                                                        @elseif($submission->grade >= 70) bg-warning
                                                        @elseif($submission->grade >= 60) bg-secondary
                                                        @else bg-danger
                                                        @endif">
                                                        {{ $submission->grade }}/100 ({{ $submission->grade_letter }})
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">Not Graded</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($submission->is_graded)
                                                    <span class="badge bg-success">Graded</span>
                                                    <br><small class="text-muted">{{ $submission->graded_at->format('M d, Y') }}</small>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical" role="group">
                                                    <button type="button" class="btn btn-sm btn-primary mb-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#gradeModal{{ $submission->id }}">
                                                        <i class="las la-edit"></i> Grade
                                                    </button>
                                                    
                                                    @if($submission->is_graded && $submission->grade >= 70)
                                                        @php
                                                            $hasCertificate = App\Models\Certificate::where('user_id', $submission->user_id)
                                                                                                  ->where('task_id', $submission->task_id)
                                                                                                  ->where('type', 'task')
                                                                                                  ->exists();
                                                        @endphp
                                                        
                                                        @if(!$hasCertificate)
                                                            <form action="{{ route('tutor.submissions.certificate', $submission) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success" 
                                                                        onclick="return confirm('Issue certificate for this completed task?')">
                                                                    <i class="las la-certificate"></i> Issue Certificate
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="badge bg-success">
                                                                <i class="las la-certificate"></i> Certificate Issued
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-inbox display-1 text-muted"></i>
                            <h5 class="mt-3">No Submissions Yet</h5>
                            <p class="text-muted">Students haven't submitted their work yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grade Modals -->
@foreach($submissions as $submission)
<div class="modal fade" id="gradeModal{{ $submission->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tutor.submissions.grade', $submission) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Grade Submission - {{ $submission->user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="grade{{ $submission->id }}" class="form-label">Grade (0-100) *</label>
                        <input type="number" class="form-control" id="grade{{ $submission->id }}" 
                               name="grade" min="0" max="100" value="{{ $submission->grade }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="feedback{{ $submission->id }}" class="form-label">Feedback</label>
                        <textarea class="form-control" id="feedback{{ $submission->id }}" 
                                  name="feedback" rows="4" 
                                  placeholder="Provide feedback to the student...">{{ $submission->feedback }}</textarea>
                    </div>
                    
                    @if($submission->content)
                        <div class="mb-3">
                            <label class="form-label">Student's Text Submission:</label>
                            <div class="border p-3 bg-light rounded">
                                {{ $submission->content }}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Grade</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="d-flex justify-content-start mt-3">
    <a href="{{ route('tutor.tasks.index') }}" class="btn btn-secondary">
        <i class="las la-arrow-left"></i> Back to Tasks
    </a>
</div>
@endsection