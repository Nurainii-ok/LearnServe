@extends('layouts.admin')

@section('title', 'Create New Bootcamp')

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
            <h2>Create New Bootcamp</h2>
            <a href="{{ route('admin.bootcamps') }}" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Bootcamps
            </a>
        </div>

        <form action="{{ route('admin.bootcamps.store') }}" method="POST" enctype="multipart/form-data" class="form-body">
            @csrf
            
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
            
            <div class="form-group">
                <label for="title">Bootcamp Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tutor_id">Assigned Tutor *</label>
                    <select id="tutor_id" name="tutor_id" class="form-control" required>
                        <option value="">Select a tutor</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ old('tutor_id') == $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tutor_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="level">Level *</label>
                    <select id="level" name="level" class="form-control" required>
                        <option value="">Select level</option>
                        <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('level')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="capacity">Capacity *</label>
                    <input type="number" id="capacity" name="capacity" class="form-control" value="{{ old('capacity', 20) }}" min="1" required>
                    @error('capacity')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price (Rp) *</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" min="0" step="0.01" required>
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">Start Date *</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">End Date *</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Duration *</label>
                    <input type="text" id="duration" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="e.g., 12 weeks, 3 months" required>
                    @error('duration')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g., Programming, Design">
                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="requirements">Requirements</label>
                <textarea id="requirements" name="requirements" class="form-control" placeholder="Prerequisites and requirements for this bootcamp">{{ old('requirements') }}</textarea>
                @error('requirements')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Bootcamp Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Upload an image for the bootcamp (JPEG, PNG, JPG, GIF, max 2MB)</small>
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.bootcamps') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Create Bootcamp</button>
            </div>
        </form>
    </div>
</div>
@endsection