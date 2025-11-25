@extends('layouts.admin')

@section('title', 'All Tasks')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">All Tasks Management</h4>
                    <p class="text-muted mb-0">Monitor all tasks created by tutors across the platform</p>
                </div>
                <div class="card-body">
                    @if($tasks->count() > 0)
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->total() }}</h4>
                                                <p class="mb-0">Total Tasks</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-tasks fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->where('status', 'completed')->count() }}</h4>
                                                <p class="mb-0">Completed</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-check-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->where('status', 'in_progress')->count() }}</h4>
                                                <p class="mb-0">In Progress</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-hourglass-half fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $tasks->where('status', 'overdue')->count() }}</h4>
                                                <p class="mb-0">Overdue</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="las la-exclamation-triangle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Table -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Class</th>
                                        <th>Tutor</th>
                                        <th>Due Date</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Submissions</th>
                                        <th>Graded</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $task->class->title }}</span>
                                            </td>
                                            <td>
                                                {{ $task->assignedBy->name }}
                                                <br>
                                                <small class="text-muted">{{ $task->assignedBy->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }}">
                                                    {{ $task->due_date->format('M d, Y') }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $task->due_date->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($task->priority === 'high') bg-danger
                                                    @elseif($task->priority === 'medium') bg-warning
                                                    @else bg-success
                                                    @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($task->status === 'completed') bg-success
                                                    @elseif($task->status === 'overdue') bg-danger
                                                    @elseif($task->status === 'in_progress') bg-warning
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $task->submissions->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $task->submissions->whereNotNull('grade')->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $task->created_at->format('M d, Y') }}
                                                <br>
                                                <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-tasks display-1 text-muted"></i>
                            <h5 class="mt-3">No Tasks Found</h5>
                            <p class="text-muted">No tasks have been created by tutors yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection