@extends('layouts.admin')

@section('title', 'Video Content Details')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
}

.video-detail-container {
    max-width: 1200px;
    margin: 0 auto;
}

.video-header {
    background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.video-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0.9;
}

.video-player-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.video-player {
    width: 100%;
    height: 500px;
    background: #000;
}

.video-info-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.info-group h6 {
    color: var(--primary-brown);
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.info-value {
    color: #374151;
    font-size: 1rem;
    line-height: 1.6;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-inactive {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.course-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
}

.course-class {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.course-bootcamp {
    background: rgba(148, 78, 37, 0.1);
    color: var(--primary-brown);
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
}

.btn-primary:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.thumbnail-preview {
    max-width: 300px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .video-meta {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .video-player {
        height: 250px;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="video-detail-container">
        <!-- Video Header -->
        <div class="video-header">
            <h1 class="video-title">{{ $videoContent->title }}</h1>
            <div class="video-meta">
                <div class="meta-item">
                    <i class="bx bx-calendar"></i>
                    <span>Created {{ $videoContent->created_at->format('M d, Y') }}</span>
                </div>
                @if($videoContent->duration)
                <div class="meta-item">
                    <i class="bx bx-time"></i>
                    <span>{{ $videoContent->formatted_duration }}</span>
                </div>
                @endif
                <div class="meta-item">
                    <i class="bx bx-user"></i>
                    <span>By {{ $videoContent->creator->name }}</span>
                </div>
            </div>
        </div>

        <!-- Video Player -->
        <div class="video-player-section">
            @php
                $embedUrl = '';
                if (strpos($videoContent->video_url, 'youtube.com') !== false || strpos($videoContent->video_url, 'youtu.be') !== false) {
                    // YouTube URL
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $videoContent->video_url, $matches);
                    if (isset($matches[1])) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                    }
                } elseif (strpos($videoContent->video_url, 'vimeo.com') !== false) {
                    // Vimeo URL
                    preg_match('/vimeo\.com\/(\d+)/', $videoContent->video_url, $matches);
                    if (isset($matches[1])) {
                        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                    }
                } else {
                    // Direct video URL
                    $embedUrl = $videoContent->video_url;
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

        <!-- Video Information -->
        <div class="video-info-section">
            <div class="info-grid">
                <div class="info-group">
                    <h6>Description</h6>
                    <div class="info-value">
                        {{ $videoContent->description ?: 'No description provided.' }}
                    </div>
                </div>

                <div class="info-group">
                    <h6>Course Information</h6>
                    <div class="info-value">
                        @if($videoContent->class)
                            <span class="course-badge course-class">Class</span><br>
                            <strong>{{ $videoContent->class->title }}</strong><br>
                            <small class="text-muted">Instructor: {{ $videoContent->class->tutor->name ?? 'Unknown' }}</small>
                        @elseif($videoContent->bootcamp)
                            <span class="course-badge course-bootcamp">Bootcamp</span><br>
                            <strong>{{ $videoContent->bootcamp->title }}</strong><br>
                            <small class="text-muted">Instructor: {{ $videoContent->bootcamp->tutor->name ?? 'Unknown' }}</small>
                        @else
                            <span class="text-muted">No course assigned</span>
                        @endif
                    </div>
                </div>

                <div class="info-group">
                    <h6>Status</h6>
                    <div class="info-value">
                        <span class="status-badge status-{{ $videoContent->status }}">
                            {{ ucfirst($videoContent->status) }}
                        </span>
                    </div>
                </div>

                <div class="info-group">
                    <h6>Order</h6>
                    <div class="info-value">
                        Position {{ $videoContent->order }} in course sequence
                    </div>
                </div>

                <div class="info-group">
                    <h6>Video URL</h6>
                    <div class="info-value">
                        <a href="{{ $videoContent->video_url }}" target="_blank" class="text-primary">
                            {{ Str::limit($videoContent->video_url, 50) }}
                        </a>
                    </div>
                </div>

                @if($videoContent->thumbnail)
                <div class="info-group">
                    <h6>Thumbnail</h6>
                    <div class="info-value">
                        <img src="{{ asset('storage/' . $videoContent->thumbnail) }}" 
                             alt="Video thumbnail" class="thumbnail-preview">
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ session('role') === 'admin' ? route('admin.video-contents.edit', $videoContent) : route('tutor.video-contents.edit', $videoContent) }}" 
                   class="btn-action btn-primary">
                    <i class="bx bx-edit"></i> Edit Video
                </a>
                
                <a href="{{ session('role') === 'admin' ? route('admin.video-contents.index') : route('tutor.video-contents.index') }}" 
                   class="btn-action btn-secondary">
                    <i class="bx bx-arrow-back"></i> Back to List
                </a>
                
                <form action="{{ session('role') === 'admin' ? route('admin.video-contents.destroy', $videoContent) : route('tutor.video-contents.destroy', $videoContent) }}" 
                      method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this video content?')">
                        <i class="bx bx-trash"></i> Delete Video
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection