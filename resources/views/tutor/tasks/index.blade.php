@extends('layouts.tutor')

@section('title', 'My Tasks')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Tasks</h4>
                    <a href="{{ route('tutor.tasks.create') }}" class="btn btn-primary">
                        <i class="las la-plus"></i> Create New Task
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Class</th>
                                        <th>Due Date</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Submissions</th>
                                        <th>Graded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                            </td>
                                            <td>{{ $task->class->title }}</td>
                                            <td>
                                                <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }}">
                                                    {{ $task->due_date->format('M d, Y H:i') }}
                                                </span>
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
                                                    {{ $task->submission_count }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $task->graded_count }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tutor.tasks.show', $task) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="View Submissions">
                                                        <i class="las la-eye"></i>
                                                    </a>
                                                </div>
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
                            <h5 class="mt-3">No Tasks Yet</h5>
                            <p class="text-muted">Create your first task to get started.</p>
                            <a href="{{ route('tutor.tasks.create') }}" class="btn btn-primary">
                                <i class="las la-plus"></i> Create Task
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection