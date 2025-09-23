@extends('layouts.tutor')

@section('title', 'Add Video Content')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Video Content</h5>
                    <a href="{{ route('tutor.video-contents.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tutor.video-contents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ old('title') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="video_url" class="form-label">Video URL <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="video_url" name="video_url" 
                                           value="{{ old('video_url') }}" required 
                                           placeholder="https://www.youtube.com/watch?v=... or https://vimeo.com/...">
                                    <div class="form-text">Supported: YouTube, Vimeo, or direct video URLs</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration (seconds)</label>
                                            <input type="number" class="form-control" id="duration" name="duration" 
                                                   value="{{ old('duration') }}" min="1" placeholder="e.g., 300 for 5 minutes">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Order</label>
                                            <input type="number" class="form-control" id="order" name="order" 
                                                   value="{{ old('order', 0) }}" min="0">
                                            <div class="form-text">Lower numbers appear first</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <div class="form-text">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Course Type <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="course_type" id="course_type_class" 
                                               value="class" {{ old('course_type') === 'class' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="course_type_class">Class</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="course_type" id="course_type_bootcamp" 
                                               value="bootcamp" {{ old('course_type') === 'bootcamp' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="course_type_bootcamp">Bootcamp</label>
                                    </div>
                                </div>

                                <div class="mb-3" id="class_select" style="display: none;">
                                    <label for="class_id" class="form-label">Select Class</label>
                                    <select class="form-select" id="class_id" name="class_id">
                                        <option value="">Choose a class...</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3" id="bootcamp_select" style="display: none;">
                                    <label for="bootcamp_id" class="form-label">Select Bootcamp</label>
                                    <select class="form-select" id="bootcamp_id" name="bootcamp_id">
                                        <option value="">Choose a bootcamp...</option>
                                        @foreach($bootcamps as $bootcamp)
                                            <option value="{{ $bootcamp->id }}" {{ old('bootcamp_id') == $bootcamp->id ? 'selected' : '' }}>
                                                {{ $bootcamp->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tutor.video-contents.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Save Video Content
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
    const courseTypeRadios = document.querySelectorAll('input[name="course_type"]');
    const classSelect = document.getElementById('class_select');
    const bootcampSelect = document.getElementById('bootcamp_select');
    
    function toggleCourseSelects() {
        const selectedType = document.querySelector('input[name="course_type"]:checked');
        
        if (selectedType) {
            if (selectedType.value === 'class') {
                classSelect.style.display = 'block';
                bootcampSelect.style.display = 'none';
                document.getElementById('bootcamp_id').value = '';
            } else if (selectedType.value === 'bootcamp') {
                classSelect.style.display = 'none';
                bootcampSelect.style.display = 'block';
                document.getElementById('class_id').value = '';
            }
        } else {
            classSelect.style.display = 'none';
            bootcampSelect.style.display = 'none';
        }
    }
    
    courseTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleCourseSelects);
    });
    
    // Initialize on page load
    toggleCourseSelects();
});
</script>
@endsection