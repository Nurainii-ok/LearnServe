@extends('layouts.member')

@section('title', $bootcamp->title . ' - E-Learning')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
}

.course-header {
    background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.video-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    border: none;
    margin-bottom: 1.5rem;
}

.video-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.video-thumbnail {
    height: 200px;
    background: linear-gradient(45deg, var(--primary-gold), var(--soft-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.video-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-thumbnail i {
    font-size: 3rem;
    color: white;
    opacity: 0.8;
}

.play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.7);
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.video-card:hover .play-overlay {
    background: rgba(0,0,0,0.9);
    transform: translate(-50%, -50%) scale(1.1);
}

.video-content {
    padding: 1.5rem;
}

.video-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-brown);
    margin-bottom: 0.5rem;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.video-meta i {
    color: var(--primary-gold);
}

.video-description {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.5;
}

.empty-videos {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.empty-videos i {
    font-size: 4rem;
    color: var(--primary-gold);
    margin-bottom: 1.5rem;
}

.empty-videos h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
}

.empty-videos p {
    color: #6b7280;
}

.instructor-info {
    background: var(--light-cream);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.instructor-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-gold);
}

.btn-back {
    background: var(--primary-gold);
    color: var(--primary-brown);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: var(--soft-gold);
    color: var(--deep-brown);
    text-decoration: none;
}

.bootcamp-badge {
    background: linear-gradient(45deg, var(--primary-gold), var(--soft-gold));
    color: var(--primary-brown);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('elearning.index') }}" class="btn-back">
            <i class="bx bx-arrow-back"></i>
            Back to E-Learning
        </a>
    </div>

    <!-- Course Header -->
    <div class="course-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">{{ $bootcamp->title }}</h1>
                <p class="mb-3">{{ $bootcamp->description }}</p>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span><i class="bx bx-user me-1"></i> {{ $bootcamp->tutor->name ?? 'Instructor' }}</span>
                    <span><i class="bx bx-time me-1"></i> {{ $bootcamp->duration ?? 'Flexible Duration' }}</span>
                    <span><i class="bx bx-calendar me-1"></i> Enrolled {{ $enrollment->created_at->format('M d, Y') }}</span>
                    @if($bootcamp->level)
                        <span><i class="bx bx-trending-up me-1"></i> {{ ucfirst($bootcamp->level) }} Level</span>
                    @endif
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="bootcamp-badge">
                    <i class="bx bx-graduation"></i>
                    Bootcamp Course
                </div>
            </div>
        </div>
    </div>

    @if($bootcamp->tutor)
    <!-- Instructor Info -->
    <div class="instructor-info">
        <div class="d-flex align-items-center">
            <img src="{{ $bootcamp->tutor->profile_picture ? asset('storage/' . $bootcamp->tutor->profile_picture) : asset('assets/default-avatar.png') }}" 
                 alt="{{ $bootcamp->tutor->name }}" class="instructor-avatar me-3">
            <div>
                <h6 class="mb-1 text-primary">Your Bootcamp Instructor</h6>
                <h5 class="mb-1">{{ $bootcamp->tutor->name }}</h5>
                <p class="text-muted mb-0">{{ $bootcamp->tutor->bio ?? 'Expert instructor with industry experience ready to guide your intensive learning journey.' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Video Content -->
    @if($videos->count() > 0)
        <div class="row">
            <div class="col-12">
                <h4 class="mb-4">Bootcamp Videos ({{ $videos->count() }} videos)</h4>
            </div>
            @foreach($videos as $video)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('elearning.watch', $video->id) }}" class="text-decoration-none">
                        <div class="video-card">
                            <div class="video-thumbnail">
                                @if($video->thumbnail)
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}">
                                @else
                                    <i class="bx bx-play-circle"></i>
                                @endif
                                <div class="play-overlay">
                                    <i class="bx bx-play"></i>
                                </div>
                            </div>
                            
                            <div class="video-content">
                                <h6 class="video-title">{{ $video->title }}</h6>
                                <div class="video-meta">
                                    @if($video->duration)
                                        <span><i class="bx bx-time"></i> {{ $video->formatted_duration }}</span>
                                    @endif
                                    <span><i class="bx bx-sort-alt-2"></i> Module {{ $loop->iteration }}</span>
                                </div>
                                @if($video->description)
                                    <p class="video-description">{{ Str::limit($video->description, 100) }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-videos">
            <i class="bx bx-video-off"></i>
            <h3>No Videos Available</h3>
            <p>The instructor hasn't uploaded any video content for this bootcamp yet. Please check back later.</p>
        </div>
    @endif
</div>
@endsection