@extends('layouts.tutor')

@section('title', 'Add Video Content')

@section('styles')
<style>
:root {
    --primary-gold: #ecac57;
    --primary-brown: #944e25;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --text-primary: #2c2c2c;
    --text-secondary: #666666;
    --success-green: #4a7c59;
    --info-blue: #5b7c8a;
    --border-color: #e0e0e0;
}

.video-upload-card {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.video-upload-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

.card-header-custom {
    background: var(--primary-brown);
    color: white;
    padding: 1.5rem 2rem;
    border: none;
}

.card-header-custom h4 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.video-type-toggle {
    background: var(--light-cream);
    border-radius: 12px;
    padding: 0.5rem;
    margin-bottom: 1.5rem;
    border: 2px solid var(--border-color);
}

.video-type-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    background: transparent;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    color: var(--text-secondary);
}

.video-type-btn.active {
    background: var(--primary-brown);
    color: white;
    box-shadow: 0 2px 8px rgba(148, 78, 37, 0.3);
}

.video-type-btn:hover:not(.active) {
    background: rgba(148, 78, 37, 0.1);
    color: var(--primary-brown);
}

.upload-zone {
    border: 2px dashed var(--primary-gold);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background: var(--light-cream);
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-zone:hover {
    border-color: var(--primary-brown);
    background: rgba(148, 78, 37, 0.05);
}

.upload-zone.dragover {
    border-color: var(--success-green);
    background: rgba(74, 124, 89, 0.1);
}

.upload-icon {
    font-size: 3rem;
    color: var(--primary-gold);
    margin-bottom: 1rem;
}

.form-control-modern {
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus {
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 0.2rem rgba(148, 78, 37, 0.25);
}

.btn-primary-custom {
    background: var(--primary-brown);
    border: none;
    border-radius: 10px;
    color: white;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary-custom:hover {
    background: var(--deep-brown);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(148, 78, 37, 0.4);
}

/* Ensure submit button is always clickable */
#submitBtn {
    pointer-events: auto !important;
    opacity: 1 !important;
    cursor: pointer !important;
    background: var(--primary-brown) !important;
    border: none !important;
    color: white !important;
}

#submitBtn:hover {
    background: var(--deep-brown) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 15px rgba(148, 78, 37, 0.4) !important;
}

/* Override any disabled state */
#submitBtn:disabled {
    pointer-events: auto !important;
    opacity: 1 !important;
    cursor: pointer !important;
    background: var(--primary-brown) !important;
    color: white !important;
}

.btn-secondary-custom {
    background: var(--light-cream);
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-secondary-custom:hover {
    background: var(--border-color);
    color: var(--text-primary);
}

.progress-modern {
    height: 8px;
    border-radius: 4px;
    background: var(--light-cream);
    overflow: hidden;
}

.progress-bar-modern {
    background: linear-gradient(90deg, var(--primary-gold) 0%, var(--primary-brown) 100%);
    transition: width 0.3s ease;
}

.video-preview {
    border-radius: 12px;
    overflow: hidden;
    background: var(--light-cream);
    border: 2px solid var(--border-color);
}

.form-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.section-title {
    color: var(--primary-brown);
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="video-upload-card">
                <div class="card-header-custom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>
                            <i class="bx bx-video-plus"></i>
                            Add New Video Content
                        </h4>
                        <a href="{{ route('tutor.video-contents.index') }}" class="btn btn-light btn-sm">
                            <i class="bx bx-arrow-back"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bx bx-error-circle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                            </div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger border-0 rounded-3">
                            <i class="bx bx-error-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success border-0 rounded-3">
                            <i class="bx bx-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('tutor.video-contents.store') }}" method="POST" enctype="multipart/form-data" id="videoForm">
                        @csrf
                        
                        <!-- Video Source Selection -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bx bx-movie"></i>
                                Video Source
                            </h5>
                            
                            <div class="video-type-toggle d-flex">
                                <button type="button" class="video-type-btn active" data-type="youtube">
                                    <i class="bx bxl-youtube me-2"></i>
                                    YouTube URL
                                </button>
                                <button type="button" class="video-type-btn" data-type="upload">
                                    <i class="bx bx-cloud-upload me-2"></i>
                                    Upload Video
                                </button>
                            </div>

                            <!-- YouTube URL Section -->
                            <div id="youtube-section">
                                <div class="mb-3">
                                    <label for="video_url" class="form-label fw-semibold">
                                        <i class="bx bxl-youtube text-danger me-1"></i>
                                        YouTube Video URL
                                    </label>
                                    <input type="url" class="form-control form-control-modern" id="video_url" name="video_url" 
                                           value="{{ old('video_url') }}" 
                                           placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                                    <div class="form-text">
                                        <i class="bx bx-info-circle me-1"></i>
                                        Paste the YouTube video URL here. The video will be embedded in your course.
                                    </div>
                                </div>
                            </div>

                            <!-- Video Upload Section -->
                            <div id="upload-section" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bx bx-cloud-upload text-primary me-1"></i>
                                        Upload Video File
                                    </label>
                                    <div class="upload-zone" id="uploadZone">
                                        <div class="upload-icon">
                                            <i class="bx bx-cloud-upload"></i>
                                        </div>
                                        <h5 class="mb-2">Drop your video here or click to browse</h5>
                                        <p class="text-muted mb-3">Supported formats: MP4, WebM, AVI (Max: 100MB)</p>
                                        <input type="file" id="video_file" name="video_file" accept="video/*" style="display: none;">
                                        <button type="button" class="btn btn-primary-custom" onclick="document.getElementById('video_file').click()">
                                            <i class="bx bx-folder-open me-2"></i>
                                            Choose Video File
                                        </button>
                                    </div>
                                    <div id="uploadProgress" style="display: none;" class="mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-semibold">Uploading...</span>
                                            <span id="progressText">0%</span>
                                        </div>
                                        <div class="progress-modern">
                                            <div class="progress-bar-modern" id="progressBar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div id="videoPreview" style="display: none;" class="mt-3">
                                        <div class="video-preview">
                                            <video id="previewVideo" controls style="width: 100%; max-height: 300px;"></video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bx bx-info-circle"></i>
                                Basic Information
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-semibold">
                                            Video Title <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-modern" id="title" name="title" 
                                               value="{{ old('title') }}" required 
                                               placeholder="Enter an engaging title for your video">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label fw-semibold">Description</label>
                                        <textarea class="form-control form-control-modern" id="description" name="description" rows="4" 
                                                  placeholder="Describe what students will learn from this video...">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label fw-semibold">
                                            <i class="bx bx-image me-1"></i>
                                            Thumbnail Image
                                        </label>
                                        <input type="file" class="form-control form-control-modern" id="thumbnail" name="thumbnail" 
                                               accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="form-text">
                                            <i class="bx bx-info-circle me-1"></i>
                                            Max size: 2MB. Formats: JPEG, PNG, JPG, GIF
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Assignment -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bx bx-book-bookmark"></i>
                                Course Assignment
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="class_id" class="form-label fw-semibold">Select Class <span class="text-danger">*</span></label>
                                        <select class="form-select form-control-modern" id="class_id" name="class_id" required>
                                            <option value="">Choose a class...</option>
                                            @forelse($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->title }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No classes available</option>
                                            @endforelse
                                        </select>
                                        
                                        @if($classes->count() == 0)
                                            <div class="alert alert-warning mt-2">
                                                <i class="bx bx-info-circle me-1"></i>
                                                <strong>No classes found.</strong> 
                                                You need to create a class first before adding video content.
                                                <div class="mt-2">
                                                    <a href="{{ route('tutor.classes.create') }}" class="btn btn-sm btn-primary">
                                                        <i class="bx bx-plus"></i> Create New Class
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-2">
                                                <i class="bx bx-info-circle me-1"></i>
                                                Found {{ $classes->count() }} class(es) available for video content.
                                            </div>
                                        @endif
                                        <div class="form-text">
                                            <i class="bx bx-info-circle me-1"></i>
                                            Video content can only be assigned to classes
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Settings -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bx bx-cog"></i>
                                Additional Settings
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label fw-semibold">
                                            <i class="bx bx-time me-1"></i>
                                            Duration (minutes)
                                        </label>
                                        <input type="number" class="form-control form-control-modern" id="duration" name="duration" 
                                               value="{{ old('duration') }}" min="1" placeholder="e.g., 15">
                                        <div class="form-text">Video duration in minutes</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="order" class="form-label fw-semibold">
                                            <i class="bx bx-sort me-1"></i>
                                            Order
                                        </label>
                                        <input type="number" class="form-control form-control-modern" id="order" name="order" 
                                               value="{{ old('order', 0) }}" min="0" placeholder="0">
                                        <div class="form-text">Lower numbers appear first</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-semibold">
                                            <i class="bx bx-check-circle me-1"></i>
                                            Status
                                        </label>
                                        <select class="form-select form-control-modern" id="status" name="status" required>
                                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('tutor.video-contents.index') }}" class="btn btn-secondary-custom">
                                <i class="bx bx-x me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary-custom" id="submitBtn">
                                <i class="bx bx-save me-2"></i>
                                Save Video Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Video Type Toggle
    const videoTypeButtons = document.querySelectorAll('.video-type-btn');
    const youtubeSection = document.getElementById('youtube-section');
    const uploadSection = document.getElementById('upload-section');
    const videoUrlInput = document.getElementById('video_url');
    const videoFileInput = document.getElementById('video_file');
    
    videoTypeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            
            // Update button states
            videoTypeButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Toggle sections
            if (type === 'youtube') {
                youtubeSection.style.display = 'block';
                uploadSection.style.display = 'none';
                videoUrlInput.required = true;
                videoFileInput.required = false;
                videoFileInput.value = '';
            } else {
                youtubeSection.style.display = 'none';
                uploadSection.style.display = 'block';
                videoUrlInput.required = false;
                videoFileInput.required = true;
                videoUrlInput.value = '';
            }
        });
    });
    
    // Simplified - no course type toggle needed since only classes are supported
    
    // File Upload Handling
    const uploadZone = document.getElementById('uploadZone');
    const uploadProgress = document.getElementById('uploadProgress');
    const videoPreview = document.getElementById('videoPreview');
    const previewVideo = document.getElementById('previewVideo');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    // Drag and Drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });
    
    // Click to upload
    uploadZone.addEventListener('click', function() {
        videoFileInput.click();
    });
    
    videoFileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });
    
    function handleFileSelect(file) {
        // Validate file type
        const allowedTypes = ['video/mp4', 'video/webm', 'video/avi', 'video/mov', 'video/wmv'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid video file (MP4, WebM, AVI, MOV, WMV)');
            return;
        }
        
        // Validate file size (100MB)
        const maxSize = 100 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size must be less than 100MB');
            return;
        }
        
        // Show preview
        const url = URL.createObjectURL(file);
        previewVideo.src = url;
        videoPreview.style.display = 'block';
        
        // Simulate upload progress (in real implementation, this would be actual upload)
        simulateUpload();
    }
    
    function simulateUpload() {
        uploadProgress.style.display = 'block';
        let progress = 0;
        
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;
            
            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';
            
            if (progress >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    uploadProgress.style.display = 'none';
                }, 1000);
            }
        }, 200);
    }
    
    // Form Validation
    const form = document.getElementById('videoForm');
    form.addEventListener('submit', function(e) {
        console.log('Form submit triggered');
        
        // Check if title is filled
        const titleInput = document.getElementById('title');
        if (!titleInput || !titleInput.value.trim()) {
            e.preventDefault();
            alert('Please enter a video title');
            if (titleInput) titleInput.focus();
            return false;
        }
        
        const activeType = document.querySelector('.video-type-btn.active')?.dataset.type;
        console.log('Active video type:', activeType);
        
        if (activeType === 'youtube') {
            if (!videoUrlInput.value.trim()) {
                e.preventDefault();
                alert('Please enter a YouTube URL');
                videoUrlInput.focus();
                return false;
            }
        } else if (activeType === 'upload') {
            if (!videoFileInput.files.length) {
                e.preventDefault();
                alert('Please select a video file to upload');
                return false;
            }
        }
        
        // Check class selection - only if classes are available
        const classSelect = document.getElementById('class_id');
        if (classSelect && !classSelect.value) {
            e.preventDefault();
            alert('Please select a class');
            classSelect.focus();
            return false;
        }
        
        console.log('Form validation passed, submitting...');
        return true;
    });
    
    // Ensure submit button is always enabled
    function ensureButtonEnabled() {
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.removeAttribute('disabled');
            submitBtn.style.pointerEvents = 'auto';
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
    }
    
    // Run on page load and periodically
    ensureButtonEnabled();
    setInterval(ensureButtonEnabled, 1000);
    
    // Also run when DOM changes
    const observer = new MutationObserver(ensureButtonEnabled);
    observer.observe(document.body, { childList: true, subtree: true });
    
    // Add event listeners to ensure button stays enabled
    document.addEventListener('click', ensureButtonEnabled);
    document.addEventListener('change', ensureButtonEnabled);
    document.addEventListener('input', ensureButtonEnabled);
    
    // Force enable button on any interaction
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            // Remove any disabled state before processing
            this.disabled = false;
            this.removeAttribute('disabled');
            console.log('Submit button clicked - ensuring enabled state');
        });
    }
});
</script>
@endsection