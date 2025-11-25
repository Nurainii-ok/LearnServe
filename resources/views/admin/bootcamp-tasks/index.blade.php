@extends('layouts.admin')

@section('title', 'Bootcamp Tasks Overview')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $bootcamps->count() }}</h4>
                                    <p class="mb-0">Active Bootcamps</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="las la-graduation-cap fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">{{ $totalSubmissions }}</h4>
                                    <p class="mb-0">Total Submissions</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="las la-paper-plane fa-2x"></i>
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
                                    <h4 class="mb-0">{{ $pendingReviews }}</h4>
                                    <p class="mb-0">Pending Reviews</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="las la-clock fa-2x"></i>
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
                                    <h4 class="mb-0">{{ $certificates }}</h4>
                                    <p class="mb-0">Certificates Issued</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="las la-certificate fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootcamps Overview -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">🎓 Bootcamp Tasks Overview</h4>
                    <p class="text-muted mb-0">Monitor all bootcamp activities and task submissions</p>
                </div>
                <div class="card-body">
                    @if($bootcamps->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Bootcamp</th>
                                        <th>Instructor</th>
                                        <th>Students</th>
                                        <th>Tasks</th>
                                        <th>Submissions</th>
                                        <th>Pending Reviews</th>
                                        <th>Completion Rate</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bootcamps as $bootcamp)
                                        @php
                                            $totalTasks = $bootcamp->tasks_count;
                                            $totalStudents = $bootcamp->enrolled_students_count;
                                            $allSubmissions = \App\Models\TaskSubmission::whereHas('task', function($q) use ($bootcamp) {
                                                $q->where('bootcamp_id', $bootcamp->id);
                                            });
                                            $totalSubmissions = $allSubmissions->count();
                                            $pendingSubmissions = $allSubmissions->where('submission_status', 'pending')->count();
                                            $passedSubmissions = $allSubmissions->where('submission_status', 'passed')->count();
                                            $completionRate = $totalSubmissions > 0 ? ($passedSubmissions / $totalSubmissions) * 100 : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $bootcamp->title }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($bootcamp->description, 50) }}</small>
                                            </td>
                                            <td>
                                                {{ $bootcamp->tutor->name }}
                                                <br>
                                                <small class="text-muted">{{ $bootcamp->tutor->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $totalStudents }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $totalTasks }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $totalSubmissions }}</span>
                                            </td>
                                            <td>
                                                @if($pendingSubmissions > 0)
                                                    <span class="badge bg-warning">{{ $pendingSubmissions }}</span>
                                                @else
                                                    <span class="badge bg-success">0</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-success" 
                                                             style="width: {{ $completionRate }}%"></div>
                                                    </div>
                                                    <small>{{ number_format($completionRate, 1) }}%</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($bootcamp->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($bootcamp->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-graduation-cap display-1 text-muted"></i>
                            <h5 class="mt-3">No Bootcamps</h5>
                            <p class="text-muted">No bootcamps have been created yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection