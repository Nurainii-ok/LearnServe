@extends('layouts.member')

@section('title', $video->title . ' - Watch Video')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
}

.video-player-container {
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.video-player {
    width: 100%;
    height: 500px;
    border: none;
}

.video-info {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.video-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-brown);
    margin-bottom: 1rem;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.meta-item i {
    color: var(--primary-gold);
}

.video-description {
    color: #374151;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.course-info {
    background: var(--light-cream);
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid var(--primary-gold);
}

.other-videos {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 1.5rem;
}

.other-video-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    border: 1px solid #e5e7eb;
    margin-bottom: 1rem;
}

.other-video-item:hover {
    background: var(--light-cream);
    border-color: var(--primary-gold);
    text-decoration: none;
    color: inherit;
    transform: translateX(5px);
}

.other-video-thumbnail {
    width: 80px;
    height: 60px;
    background: linear-gradient(45deg, var(--primary-gold), var(--soft-gold));
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
    overflow: hidden;
}

.other-video-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.other-video-thumbnail i {
    color: white;
    font-size: 1.5rem;
}

.other-video-info h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: var(--primary-brown);
    font-size: 0.9rem;
}

.other-video-info small {
    color: #6b7280;
    font-size: 0.75rem;
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

.navigation-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-nav {
    background: var(--primary-brown);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-nav:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-nav:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
}

@media (max-width: 768px) {
    .video-player {
        height: 250px;
    }
    
    .video-meta {
        gap: 1rem;
    }
    
    .other-video-item {
        flex-direction: column;
        text-align: center;
    }
    
    .other-video-thumbnail {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Back Button -->
    <div class="mb-3">
        @if($video->class_id)
            <a href="{{ route('elearning.class', $video->class_id) }}" class="btn-back">
                <i class="bx bx-arrow-back"></i>
                Back to {{ $video->class->title }}
            </a>
        @else
            <a href="{{ route('elearning.bootcamp', $video->bootcamp_id) }}" class="btn-back">
                <i class="bx bx-arrow-back"></i>
                Back to {{ $video->bootcamp->title }}
            </a>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Video Player -->
            <div class="video-player-container">
                @php
                    $embedUrl = '';
                    if (strpos($video->video_url, 'youtube.com') !== false || strpos($video->video_url, 'youtu.be') !== false) {
                        // YouTube URL
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $video->video_url, $matches);
                        if (isset($matches[1])) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                        }
                    } elseif (strpos($video->video_url, 'vimeo.com') !== false) {
                        // Vimeo URL
                        preg_match('/vimeo\.com\/(\d+)/', $video->video_url, $matches);
                        if (isset($matches[1])) {
                            $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                        }
                    } else {
                        // Direct video URL
                        $embedUrl = $video->video_url;
                    }
                @endphp

                @if($embedUrl)
                    @if(strpos($embedUrl, 'youtube.com') !== false || strpos($embedUrl, 'vimeo.com') !== false)
                        <iframe src="{{ $embedUrl }}" class="video-player" allowfullscreen></iframe>
                    @else
                        <video controls class="video-player">
                            <source src="{{ $embedUrl }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @else
                    <div class="video-player d-flex align-items-center justify-content-center bg-dark text-white">
                        <div class="text-center">
                            <i class="bx bx-error-circle display-4 mb-3"></i>
                            <h5>Video not available</h5>
                            <p>The video URL format is not supported.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Video Info -->
            <div class="video-info">
                <h1 class="video-title">{{ $video->title }}</h1>
                
                <div class="video-meta">
                    @if($video->duration)
                        <div class="meta-item">
                            <i class="bx bx-time"></i>
                            <span>{{ $video->formatted_duration }}</span>
                        </div>
                    @endif
                    <div class="meta-item">
                        <i class="bx bx-calendar"></i>
                        <span>Added {{ $video->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($video->creator)
                        <div class="meta-item">
                            <i class="bx bx-user"></i>
                            <span>{{ $video->creator->name }}</span>
                        </div>
                    @endif
                </div>

                @if($video->description)
                    <div class="video-description">
                        <h6 class="mb-2">Description</h6>
                        <p>{{ $video->description }}</p>
                    </div>
                @endif

                <div class="course-info">
                    <div class="d-flex align-items-center">
                        <i class="bx {{ $video->class_id ? 'bx-book-open' : 'bx-graduation' }} me-2 text-primary"></i>
                        <div>
                            <strong>{{ $video->class_id ? 'Class' : 'Bootcamp' }}: </strong>
                            {{ $video->class_id ? $video->class->title : $video->bootcamp->title }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Other Videos -->
            @if($otherVideos->count() > 0)
                <div class="other-videos">
                    <h5 class="mb-3">
                        <i class="bx bx-list-ul me-2"></i>
                        Other Videos in this {{ $video->class_id ? 'Class' : 'Bootcamp' }}
                    </h5>
                    
                    @foreach($otherVideos as $otherVideo)
                        <a href="{{ route('elearning.watch', $otherVideo->id) }}" class="other-video-item">
                            <div class="other-video-thumbnail">
                                @if($otherVideo->thumbnail)
                                    <img src="{{ asset('storage/' . $otherVideo->thumbnail) }}" alt="{{ $otherVideo->title }}">
                                @else
                                    <i class="bx bx-play-circle"></i>
                                @endif
                            </div>
                            <div class="other-video-info">
                                <h6>{{ $otherVideo->title }}</h6>
                                <small>
                                    @if($otherVideo->duration)
                                        <i class="bx bx-time me-1"></i>{{ $otherVideo->formatted_duration }}
                                    @endif
                                </small>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection