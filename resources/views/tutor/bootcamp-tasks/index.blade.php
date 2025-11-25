@extends('layouts.tutor')

@section('title', 'Bootcamp Task Reviews')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">📝 Bootcamp Task Reviews</h4>
                    <p class="text-muted mb-0">Review submissions from your bootcamp students</p>
                </div>
                <div class="card-body">
                    @if($bootcamps->count() > 0)
                        <div class="row">
                            @foreach($bootcamps as $bootcamp)
                                @php
                                    $pendingSubmissions = $bootcamp->tasks->flatMap->submissions->where('submission_status', 'pending')->count();
                                    $underReviewSubmissions = $bootcamp->tasks->flatMap->submissions->where('submission_status', 'under_review')->count();
                                    $totalPendingReviews = $pendingSubmissions + $underReviewSubmissions;
                                @endphp
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 {{ $totalPendingReviews > 0 ? 'border-warning' : 'border-success' }}">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">{{ $bootcamp->title }}</h6>
                                            <small>{{ $bootcamp->tasks->count() }} Tasks</small>
                                        </div>
                                        <div class="card-body">
                                            <!-- Pending Reviews -->
                                            <div class="row text-center mb-3">
                                                <div class="col-6">
                                                    <div class="border-end">
                                                        <h4 class="mb-0 {{ $totalPendingReviews > 0 ? 'text-warning' : 'text-success' }}">
                                                            {{ $totalPendingReviews }}
                                                        </h4>
                                                        <small class="text-muted">Pending Reviews</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="mb-0 text-info">
                                                        {{ $bootcamp->tasks->flatMap->submissions->count() }}
                                                    </h4>
                                                    <small class="text-muted">Total Submissions</small>
                                                </div>
                                            </div>

                                            <!-- Status Breakdown -->
                                            <div class="mb-3">
                                                @php
                                                    $allSubmissions = $bootcamp->tasks->flatMap->submissions;
                                                    $passedCount = $allSubmissions->where('submission_status', 'passed')->count();
                                                    $revisionCount = $allSubmissions->where('submission_status', 'revision')->count();
                                                    $failedCount = $allSubmissions->where('submission_status', 'failed')->count();
                                                @endphp
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small>Passed: {{ $passedCount }}</small>
                                                    <small>Revision: {{ $revisionCount }}</small>
                                                    <small>Failed: {{ $failedCount }}</small>
                                                </div>
                                                
                                                <div class="progress" style="height: 6px;">
                                                    @if($allSubmissions->count() > 0)
                                                        <div class="progress-bar bg-success" style="width: {{ ($passedCount / $allSubmissions->count()) * 100 }}%"></div>
                                                        <div class="progress-bar bg-warning" style="width: {{ ($revisionCount / $allSubmissions->count()) * 100 }}%"></div>
                                                        <div class="progress-bar bg-danger" style="width: {{ ($failedCount / $allSubmissions->count()) * 100 }}%"></div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Priority Indicator -->
                                            @if($totalPendingReviews > 0)
                                                <div class="alert alert-warning py-2">
                                                    <i class="las la-clock"></i>
                                                    <strong>{{ $totalPendingReviews }}</strong> submissions need your review
                                                </div>
                                            @else
                                                <div class="alert alert-success py-2">
                                                    <i class="las la-check-circle"></i>
                                                    All submissions reviewed!
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('tutor.bootcamp-tasks.submissions', $bootcamp->id) }}" 
                                               class="btn btn-primary w-100">
                                                <i class="las la-eye"></i> Review Submissions
                                                @if($totalPendingReviews > 0)
                                                    <span class="badge bg-warning ms-2">{{ $totalPendingReviews }}</span>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-graduation-cap display-1 text-muted"></i>
                            <h5 class="mt-3">No Bootcamps</h5>
                            <p class="text-muted">You don't have any bootcamps with task submissions yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection