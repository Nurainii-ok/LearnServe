@extends('layouts.tutor')

@section('title', 'Profile & Settings')

@section('content')
<style>
    .profile-hero {
        background: #F3EFEC;
        border-radius: 16px;
        padding: 40px 30px;
    }

    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .soft-card {
        border-radius: 14px;
        border: 1px solid #e9e5e3;
        background: white;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .info-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #9b9793;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 1rem;
        color: #333;
        font-weight: 500;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #4a4745;
    }

    .edit-btn {
        border-radius: 8px;
        font-size: 0.85rem;
    }

    .stat-box {
        padding: 18px;
        background: #F9F7F6;
        border-radius: 12px;
        border: 1px solid #ece7e5;
        text-align: center;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: bold;
        color: #4a4745;
    }

    .stat-label {
        font-size: .85rem;
        color: #8b8582;
    }
</style>

<div class="container-fluid px-4">

    <!-- HEADER -->
    <!--<h1 class="mt-4" style="color:#4a4745;">Profile & Settings</h1>-->
    <ol class="breadcrumb mb-4" style="color:#6d6866;">
        <li class="breadcrumb-item">
            <a href="{{ route('tutor.dashboard') }}" style="color:#6d6866;">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Profile & Settings</li>
    </ol>

    <!-- ALERTS -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- PROFILE HERO -->
    <div class="profile-hero mb-4 shadow-sm">
        <div class="row align-items-center">
            
            <div class="col-md-3 text-center">
                @if($tutor->profile_photo)
                    <img src="{{ asset('storage/profile_photos/'.$tutor->profile_photo) }}" 
                         class="profile-photo">
                @else
                    <div class="d-flex align-items-center justify-content-center profile-photo" style="background:#d9d6d3;">
                        <i class="fas fa-user" style="font-size: 2.5rem; color:white;"></i>
                    </div>
                @endif
            </div>

            <div class="col-md-9">
                <h2 class="fw-bold" style="color:#3d3c3a;">{{ $tutor->name }}</h2>
                <p class="text-muted mb-1">{{ $tutor->email }}</p>
                <button class="btn btn-dark edit-btn" onclick="window.location='{{ route('tutor.account.edit') }}'">
                    <i class="fas fa-edit me-1"></i> Edit Profile
                </button>
            </div>

        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-xl-8">

            <!-- PERSONAL INFO -->
            <div class="soft-card mb-4">
                <div class="section-title">Personal Information</div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $tutor->name }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $tutor->email }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ $tutor->created_at->format('M d, Y') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-label">Last Active</div>
                        <div class="info-value">{{ $tutor->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- SECURITY -->
            <div class="soft-card mb-4">
                <div class="section-title">Security Settings</div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold" style="color:#4a4745;">Password</div>
                        <small class="text-muted">Last updated: {{ $tutor->updated_at->format('M d, Y') }}</small>
                    </div>

                    <button class="btn btn-dark edit-btn" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-1"></i> Change Password
                    </button>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-xl-4">

            <div class="soft-card mb-4">
                <div class="section-title">Teaching Overview</div>

                <div class="row g-2">
                    <div class="col-6">
                        <div class="stat-box">
                            <div class="stat-value">{{ $totalClasses }}</div>
                            <div class="stat-label">Classes</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="stat-box">
                            <div class="stat-value">{{ $totalStudents }}</div>
                            <div class="stat-label">Students</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="stat-box mt-2">
                            <div class="stat-value">${{ number_format($totalEarnings, 0) }}</div>
                            <div class="stat-label">Total Earnings</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<!-- CHANGE PASSWORD MODAL -->
<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="background:#F3EFEC;">
                <h5 class="modal-title"><i class="fas fa-key me-1"></i> Change Password</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('tutor.account.password.update') }}" method="POST">
                @csrf @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-muted">Min 4 characters.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark">Update Password</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
