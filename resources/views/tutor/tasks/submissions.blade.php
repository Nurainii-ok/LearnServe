@extends('layouts.tutor')

@section('title', 'Task Submissions - ' . $task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Task Info Header -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">{{ $task->title }}</h4>
                            <p class="text-muted mb-0">
                                @if($task->bootcamp)
                                    Bootcamp: {{ $task->bootcamp->title }}
                                @elseif($task->class)
                                    Class: {{ $task->class->title }}
                                @else
                                    Course: N/A
                                @endif
                            </p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('tutor.tasks.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left"></i> Back to Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submissions List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Student Submissions ({{ $submissions->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th>Grade</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $submission)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar rounded-circle me-2" style="background: #f4a261; color: white; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                                    {{ strtoupper(substr($submission->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $submission->user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $submission->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $submission->created_at->format('M d, Y H:i') }}
                                            @if($submission->is_late)
                                                <br><span class="badge bg-warning">Late</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($submission->submission_status === 'passed') bg-success
                                                @elseif($submission->submission_status === 'revision') bg-warning
                                                @elseif($submission->submission_status === 'failed') bg-danger
                                                @else bg-info
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $submission->submission_status ?? 'pending')) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($submission->grade)
                                                <span class="badge 
                                                    @if($submission->grade >= 90) bg-success
                                                    @elseif($submission->grade >= 80) bg-info
                                                    @elseif($submission->grade >= 70) bg-warning
                                                    @else bg-danger
                                                    @endif">
                                                    {{ $submission->grade }}/100
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Not Graded</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('tutor.tasks.submission.review', $submission->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="las la-edit"></i> Review
                                                </a>
                                                @if($submission->submission_status === 'passed' && $submission->certificate_file)
                                                    <a href="{{ asset('storage/' . $submission->certificate_file) }}" class="btn btn-sm btn-success" download>
                                                        <i class="las la-download"></i> Certificate
                                                    </a>
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
@endsection