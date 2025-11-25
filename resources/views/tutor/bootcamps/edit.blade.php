@extends('layouts.tutor')

@section('title', 'Edit Bootcamp')

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

.dashboard-content {
    padding: 0;
    margin: 0;
    padding-top: 1rem;
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
<div class="dashboard-content">
    <div class="form-container">
        <div class="form-header">
            <h2>Edit Bootcamp: {{ $bootcamp->title }}</h2>
            <a href="{{ route('tutor.bootcamps') }}" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Bootcamps
            </a>
        </div>

        <form action="{{ route('tutor.bootcamps.update', $bootcamp->id) }}" method="POST" class="form-body">
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
            
            <div class="status-badge status-{{ $bootcamp->status }}">
                Status: {{ ucfirst($bootcamp->status) }}
            </div>
            
            <div class="form-group">
                <label for="title">Bootcamp Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $bootcamp->title) }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $bootcamp->description) }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">-- Select Category --</option>
                        <option value="Design & Development" {{ old('category', $bootcamp->category) == 'Design & Development' ? 'selected' : '' }}>Design & Development</option>
                        <option value="Marketing & Communication" {{ old('category', $bootcamp->category) == 'Marketing & Communication' ? 'selected' : '' }}>Marketing & Communication</option>
                        <option value="Digital Marketing" {{ old('category', $bootcamp->category) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                        <option value="Business & Consulting" {{ old('category', $bootcamp->category) == 'Business & Consulting' ? 'selected' : '' }}>Business & Consulting</option>
                        <option value="Finance Management" {{ old('category', $bootcamp->category) == 'Finance Management' ? 'selected' : '' }}>Finance Management</option>
                        <option value="Self Development" {{ old('category', $bootcamp->category) == 'Self Development' ? 'selected' : '' }}>Self Development</option>
                    </select>
                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity *</label>
                    <input type="number" id="capacity" name="capacity" class="form-control" value="{{ old('capacity', $bootcamp->capacity) }}" min="1" required>
                    @error('capacity')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (Rp) *</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $bootcamp->price) }}" min="0" step="0.01" required>
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Duration (Days) *</label>
                    <input type="number" id="duration" name="duration" class="form-control" value="{{ old('duration', $bootcamp->duration) }}" min="1" required>
                    @error('duration')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="schedule">Schedule</label>
                    <input type="text" id="schedule" name="schedule" class="form-control" value="{{ old('schedule', $bootcamp->schedule) }}" placeholder="e.g., Mon-Fri 9:00-17:00">
                    @error('schedule')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="active" {{ old('status', $bootcamp->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $bootcamp->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="completed" {{ old('status', $bootcamp->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="zoom_link">Zoom Meeting Link</label>
                    <input type="url" 
                           id="zoom_link" 
                           name="zoom_link" 
                           class="form-control" 
                           value="{{ old('zoom_link', $bootcamp->zoom_link) }}"
                           placeholder="https://zoom.us/j/1234567890">
                    <small class="form-text text-muted">
                        <i class="las la-info-circle"></i> 
                        Enter Zoom meeting link for students to join live sessions
                    </small>
                    @error('zoom_link')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('tutor.bootcamps') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Bootcamp</button>
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
});
</script>
@endsection
