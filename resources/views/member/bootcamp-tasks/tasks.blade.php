@extends('layouts.member')

@section('title', 'Tugas - ' . $bootcamp->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Bootcamp Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-1">{{ $bootcamp->title }}</h4>
                            <p class="text-muted mb-2">Instructor: {{ $bootcamp->tutor->name }}</p>
                            <div class="d-flex align-items-center">
                                <div class="me-4">
                                    <small class="text-muted">Progress:</small>
                                    <div class="progress mt-1" style="width: 200px; height: 8px;">
                                        <div class="progress-bar bg-success" 
                                             style="width: {{ $bootcampUser->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                <div class="me-4">
                                    <small class="text-muted">Completed:</small>
                                    <strong>{{ $bootcampUser->completion_ratio }}</strong>
                                </div>
                                @if($bootcampUser->average_score)
                                    <div>
                                        <small class="text-muted">Average:</small>
                                        <span class="badge bg-info">{{ number_format($bootcampUser->average_score, 1) }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <!-- Zoom Meeting Button -->
                            @if($bootcamp->zoom_link)
                                <a href="{{ $bootcamp->zoom_link }}" 
                                   class="btn btn-primary mb-2" 
                                   target="_blank">
                                    <i class="las la-video"></i> Join Meeting
                                </a>
                                <br>
                            @endif
                            
                            @if($bootcampUser->certificate_eligible)
                                <span class="badge bg-success fs-6">
                                    <i class="las la-trophy"></i> Certificate Ready!
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📋 Daftar Tugas</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="30%">Tugas</th>
                                        <th width="15%">Tipe</th>
                                        <th width="15%">Due Date</th>
                                        <th width="15%">Status</th>
                                        <th width="10%">Score</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        @php
                                            $submission = $task->submissions->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">{{ $task->task_order }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                                                @if($task->task_type === 'final_project')
                                                    <br><span class="badge bg-warning">Final Project</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($task->task_type === 'final_project') bg-danger
                                                    @elseif($task->task_type === 'project') bg-warning
                                                    @elseif($task->task_type === 'quiz') bg-info
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $task->task_type_display }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    <small class="{{ $task->is_overdue ? 'text-danger fw-bold' : 'text-muted' }}">
                                                        {{ $task->due_date->format('M d, Y') }}
                                                    </small>
                                                    @if($task->is_overdue && !$submission?->is_passed)
                                                        <br><span class="badge bg-danger">Overdue</span>
                                                    @endif
                                                @else
                                                    <small class="text-muted">No deadline</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($submission)
                                                    <span class="badge {{ $submission->status_badge_class }}">
                                                        {{ $submission->status_display }}
                                                    </span>
                                                    @if($submission->revision_count > 0)
                                                        <br><small class="text-muted">Revisi: {{ $submission->revision_count }}</small>
                                                    @endif
                                                @else
                                                    <span class="badge bg-light text-dark">Not Submitted</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($submission && $submission->grade)
                                                    <span class="badge 
                                                        @if($submission->grade >= 90) bg-success
                                                        @elseif($submission->grade >= 80) bg-info
                                                        @elseif($submission->grade >= 70) bg-warning
                                                        @else bg-danger
                                                        @endif">
                                                        {{ $submission->grade }}%
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$submission)
                                                    <a href="{{ route('member.bootcamp-tasks.task-detail', [$bootcamp->id, $task->id]) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="las la-upload"></i> Submit
                                                    </a>
                                                @elseif($submission->can_resubmit)
                                                    <a href="{{ route('member.bootcamp-tasks.task-detail', [$bootcamp->id, $task->id]) }}" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="las la-redo"></i> Revisi
                                                    </a>
                                                @else
                                                    <a href="{{ route('member.bootcamp-tasks.task-detail', [$bootcamp->id, $task->id]) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="las la-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-tasks display-1 text-muted"></i>
                            <h5 class="mt-3">Belum Ada Tugas</h5>
                            <p class="text-muted">Tugas untuk bootcamp ini belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-start mt-3">
    <a href="{{ route('member.bootcamp-tasks') }}" class="btn btn-secondary">
        <i class="las la-arrow-left"></i> Kembali ke Bootcamp
    </a>
</div>
@endsection