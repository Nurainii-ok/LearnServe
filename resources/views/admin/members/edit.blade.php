@extends('layouts.admin')

@section('title', 'Edit Member')

@section('styles')
<style>
.page-container {
    padding: 0;
    margin: 0;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    background: white;
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin: 0 2rem 2rem 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 2rem;
}

.form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.form-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
}

.form-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.form-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-gold);
    background: white;
    box-shadow: 0 0 0 3px rgba(236, 172, 87, 0.1);
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    background: var(--deep-brown);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(148, 78, 37, 0.3);
}

.btn-secondary {
    background: #6b7280;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
}

.button-group {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
    margin-top: 2rem;
}
</style>
@endsection

@section('content')
<div class="page-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Edit Member: {{ $member->name }}</h1>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Member Information</h2>
            </div>
            
            <div class="form-body">
                <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-control" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email', $member->email) }}" class="form-control" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                            Leave blank to keep current password. Minimum 4 characters if changing.
                        </small>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('admin.members') }}" class="btn-secondary">
                            <i class="las la-times"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="las la-save"></i>
                            Update Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection