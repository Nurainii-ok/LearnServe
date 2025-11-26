@extends('layouts.member')

@section('title', 'My Profile')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --text-primary: #2c2c2c;
    --text-secondary: #666666;
}

.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding-top: 70px;
}

.profile-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.profile-header {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
    padding: 1rem;
    text-align: center;
    position: relative;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, var(--primary-gold), var(--soft-gold));
    opacity: 0.1;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--primary-gold);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 auto 1rem;
    border: 4px solid rgba(255,255,255,0.2);
    position: relative;
    z-index: 1;
}

.profile-name {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 0;
    position: relative;
    z-index: 1;
    color: white !important;
}

.profile-role {
    opacity: 0.9;
    font-size: 1rem;
    margin-top: 0.5rem;
    position: relative;
    z-index: 1;
}

.profile-body {
    padding: 2rem;
}

.profile-header-flex {
    display: flex;
    align-items: center;
    text-align: left;
    gap: 1.5rem;
}

.profile-info {
    position: relative;
    z-index: 1;
}

.profile-header .profile-avatar {
    margin: 0; /* agar tidak di tengah lagi */
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
    text-transform: uppercase;
    letter-spacing: 0.05em;
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

.form-control:disabled {
    background: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
}

.btn-update {
    background: var(--primary-brown);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.btn-update:hover {
    background: var(--deep-brown);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(148, 78, 37, 0.3);
}

.success-message {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.success-message i {
    font-size: 1.25rem;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-header {
        padding: 1.5rem;
    }
    
    .profile-body {
        padding: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <!-- Profile Header -->
        <div class="profile-header profile-header-flex">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="profile-info">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-role">Member Account</p>
            </div>
        </div>


        <!-- Profile Body -->
        <div class="profile-body">
            @if(session('success'))
                <div class="success-message">
                    <i class="las la-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                
                <div class="info-grid">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">New Password (Optional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                </div>

                <button type="submit" class="btn-update">
                    <i class="las la-save"></i>
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
