@extends('layouts.admin')

@section('title', 'Edit Class')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --success-green: #10b981;
    --error-red: #ef4444;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
}

.page-container {
    padding: 2rem;
    margin: 0;
    max-width: 1200px;
    margin: 0 auto;
}

.form-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.form-header {
    background: var(--light-cream);
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-header h2 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.25rem;
    font-weight: 600;
}

.back-btn {
    background: var(--primary-brown);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s;
}

.back-btn:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.form-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.error-message {
    color: var(--error-red);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: var(--deep-brown);
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6b7280;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-secondary:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.status-inactive {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.status-completed {
    background: rgba(148, 78, 37, 0.1);
    color: var(--primary-brown);
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="form-container">
        <div class="form-header">
            <h2>Edit Class: {{ $class->title }}</h2>
            <a href="{{ route('admin.classes') }}" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Classes
            </a>
        </div>

        <form action="{{ route('admin.classes.update', $class->id) }}" method="POST" enctype="multipart/form-data" class="form-body">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
                <div class="alert alert-danger" style="background: #fee; border: 1px solid #f88; color: #c33; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.5rem 0; font-size: 0.9rem; font-weight: 600;">Please fix the following errors:</h4>
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 0.875rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="status-badge status-{{ $class->status }}">
                Status: {{ ucfirst($class->status) }}
            </div>
            
            <div class="form-group">
                <label for="title">Class Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $class->title) }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $class->description) }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tutor_id">Tutor *</label>
                    <select id="tutor_id" name="tutor_id" class="form-control" required>
                        <option value="">Select a tutor</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ old('tutor_id', $class->tutor_id) == $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tutor_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $class->category) }}" placeholder="e.g., Web Development, Programming">
                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (Rp) *</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $class->price) }}" min="0" step="0.01" required>
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="active" {{ old('status', $class->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $class->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="completed" {{ old('status', $class->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image">Class Image</label>
                @if($class->image)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset($class->image) }}" alt="Current image" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Current image</p>
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <small class="text-muted">Upload a new image to replace the current one (JPEG, PNG, JPG, GIF, WebP, max 10MB)</small>
                <div id="file-size-error" class="error-message" style="display: none;">File size must be less than 10MB</div>
                <div id="file-type-error" class="error-message" style="display: none;">Please select a valid image file (JPEG, PNG, JPG, GIF, WebP)</div>
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.classes') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Class</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus first input
    document.getElementById('title').focus();
    
    // File size validation
    const imageInput = document.getElementById('image');
    const fileSizeError = document.getElementById('file-size-error');
    const submitButton = document.querySelector('.btn-primary');
    
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        const fileTypeError = document.getElementById('file-type-error');
        
        // Reset errors
        fileSizeError.style.display = 'none';
        fileTypeError.style.display = 'none';
        
        if (file) {
            console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                fileTypeError.style.display = 'block';
                this.value = '';
                submitButton.disabled = true;
                submitButton.style.opacity = '0.6';
                submitButton.style.cursor = 'not-allowed';
                console.log('Invalid file type:', file.type);
                return;
            }
            
            // Check file size (10MB = 10 * 1024 * 1024 bytes)
            const maxSize = 10 * 1024 * 1024;
            
            if (file.size > maxSize) {
                fileSizeError.style.display = 'block';
                this.value = ''; // Clear the input
                submitButton.disabled = true;
                submitButton.style.opacity = '0.6';
                submitButton.style.cursor = 'not-allowed';
                console.log('File too large:', file.size, 'Max:', maxSize);
            } else {
                // File is valid
                submitButton.disabled = false;
                submitButton.style.opacity = '1';
                submitButton.style.cursor = 'pointer';
                console.log('File is valid');
            }
        } else {
            // No file selected, enable submit
            submitButton.disabled = false;
            submitButton.style.opacity = '1';
            submitButton.style.cursor = 'pointer';
        }
    });
    
    // Form submission validation and debugging
    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Form submitting...');
        
        const file = imageInput.files[0];
        if (file) {
            console.log('Submitting with file:', file.name, file.size);
            
            if (file.size > 10 * 1024 * 1024) {
                e.preventDefault();
                alert('Please select an image smaller than 10MB');
                return false;
            }
        } else {
            console.log('Submitting without file');
        }
        
        // Check form data
        const formData = new FormData(this);
        console.log('Form data entries:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });
});
</script>
@endsection