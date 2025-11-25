@extends('layouts.member')

@section('title', 'Tugas Bootcamp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">📝 Tugas Bootcamp Saya</h4>
                    <p class="text-muted mb-0">Kelola tugas dari bootcamp yang Anda ikuti</p>
                </div>
                <div class="card-body">
                    @if($enrolledBootcamps->count() > 0)
                        <div class="row">
                            @foreach($enrolledBootcamps as $enrollment)
                                @php
                                    $bootcamp = $enrollment->bootcamp;
                                    $certificate = $enrollment->certificate;
                                @endphp
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">{{ $bootcamp->title }}</h6>
                                            <small>Instructor: {{ $bootcamp->tutor->name }}</small>
                                        </div>
                                        <div class="card-body">
                                            <!-- Progress Bar -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small class="text-muted">Progress</small>
                                                    <small class="text-muted">{{ $enrollment->progress_percentage_formatted }}</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success" 
                                                         style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                </div>
                                            </div>

                                            <!-- Task Summary -->
                                            <div class="row text-center mb-3">
                                                <div class="col-6">
                                                    <div class="border-end">
                                                        <h5 class="mb-0 text-success">{{ $enrollment->completed_tasks }}</h5>
                                                        <small class="text-muted">Selesai</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="mb-0 text-primary">{{ $enrollment->total_tasks }}</h5>
                                                    <small class="text-muted">Total</small>
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="mb-3">
                                                @if($enrollment->certificate_eligible)
                                                    <span class="badge bg-success">
                                                        <i class="las la-trophy"></i> Eligible for Certificate
                                                    </span>
                                                @elseif($enrollment->progress_percentage >= 50)
                                                    <span class="badge bg-warning">
                                                        <i class="las la-clock"></i> In Progress
                                                    </span>
                                                @else
                                                    <span class="badge bg-info">
                                                        <i class="las la-play"></i> Getting Started
                                                    </span>
                                                @endif

                                                @if($certificate)
                                                    <span class="badge bg-gold ms-1">
                                                        <i class="las la-certificate"></i> Certified
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Average Score -->
                                            @if($enrollment->average_score)
                                                <div class="mb-3">
                                                    <small class="text-muted">Average Score:</small>
                                                    <span class="badge 
                                                        @if($enrollment->average_score >= 90) bg-success
                                                        @elseif($enrollment->average_score >= 80) bg-info
                                                        @elseif($enrollment->average_score >= 70) bg-warning
                                                        @else bg-danger
                                                        @endif">
                                                        {{ number_format($enrollment->average_score, 1) }}%
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('member.bootcamp-tasks.tasks', $bootcamp->id) }}" 
                                                   class="btn btn-primary">
                                                    <i class="las la-tasks"></i> Lihat Tugas
                                                </a>
                                                
                                                @if($bootcamp->zoom_link)
                                                    <a href="{{ $bootcamp->zoom_link }}" 
                                                       class="btn btn-success" 
                                                       target="_blank">
                                                        <i class="las la-video"></i> Join Meeting
                                                    </a>
                                                @endif
                                                
                                                @if($certificate)
                                                    <a href="{{ route('member.certificates') }}" 
                                                       class="btn btn-outline-success btn-sm">
                                                        <i class="las la-certificate"></i> Lihat Sertifikat
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="las la-graduation-cap display-1 text-muted"></i>
                            <h5 class="mt-3">Belum Ada Bootcamp</h5>
                            <p class="text-muted">Anda belum terdaftar di bootcamp manapun.</p>
                            <a href="{{ route('bootcamp') }}" class="btn btn-primary">
                                <i class="las la-search"></i> Cari Bootcamp
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gold {
    background-color: #ffd700 !important;
    color: #000 !important;
}
</style>
@endsection