@extends('layouts.member')

@section('title', 'My Tasks')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">My Tasks</h4>
                </div>
                <div class="card-body">
                    @if($tasks->count() > 0)
                        <div class="row">
                            @foreach($tasks as $task)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 
                                        @if($task->is_overdue && !$task->submissions->first()) border-danger
                                        @elseif($task->submissions->first() && $task->submissions->first()->is_graded) border-success
                                        @elseif($task->submissions->first()) border-warning
                                        @else border-info
                                        @endif">
                                        <div class="card-header d-flex justify-content-between align-items-start">
                                            <h6 class="mb-0">{{ $task->title }}</h6>
                                            <span class="badge 
                                                @if($task->priority === 'high') bg-danger
                                                @elseif($task->priority === 'medium') bg-warning
                                                @else bg-success
                                                @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text small">{{ Str::limit($task->description, 100) }}</p>
                                            
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="las la-book"></i> {{ $task->class->title }}
                                                </small>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="las la-calendar"></i> Due: 
                                                    <span class="{{ $task->is_overdue ? 'text-danger fw-bold' : '' }}">
                                                        {{ $task->due_date->format('M d, Y H:i') }}
                                                    </span>
                                                </small>
                                            </div>

                                            @php
                                                $submission = $task->submissions->first();
                                            @endphp

                                            @if($submission)
                                                <div class="mb-2">
                                                    @if($submission->is_graded)
                                                        <span class="badge bg-success">
                                                            <i class="las la-check"></i> Graded: {{ $submission->grade }}/100 ({{ $submission->grade_letter }})
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="las la-clock"></i> Submitted - Pending Grade
                                                        </span>
                                                    @endif
                                                    
                                                    @if($submission->is_late)
                                                        <br><span class="badge bg-danger mt-1">Late Submission</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="mb-2">
                                                    @if($task->is_overdue)
                                                        <span class="badge bg-danger">
                                                            <i class="las la-exclamation-triangle"></i> Overdue
                                                        </span>
                                                    @else
                                                        <span class="badge bg-info">
                                                            <i class="las la-hourglass-half"></i> Not Submitted
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('member.tasks.show', $task) }}" class="btn btn-primary btn-sm w-100">
                                                @if($submission)
                                                    <i class="las la-eye"></i> View Submission
                                                @else
                                                    <i class="las la-edit"></i> Submit Task
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-tasks display-1 text-muted"></i>
                            <h5 class="mt-3">No Tasks Available</h5>
                            <p class="text-muted">You don't have any tasks assigned yet. Check back later or contact your instructor.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card.border-danger {
    border-width: 2px;
}
.card.border-success {
    border-width: 2px;
}
.card.border-warning {
    border-width: 2px;
}
.card.border-info {
    border-width: 2px;
}
</style>
@endsection