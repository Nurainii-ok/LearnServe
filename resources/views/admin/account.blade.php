@extends('layouts.admin')

@section('title', 'Account Settings')

@section('content')
<style>
    .container-fluid {
        padding-top: 70px !important; /* Sesuaikan tinggi header */
    }
    .profile-sidebar {
        background: #fff;
        border-radius: 12px;
        padding: 20px 0;
        border: 1px solid #e5e7eb;
        
    }
    .profile-sidebar a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #555;
        font-weight: 500;
        text-decoration: none;
        transition: .2s;
    }
    .profile-sidebar a.active,
    .profile-sidebar a:hover {
        background: #FAFAF7;
        color: #ECAC57;
    }
    .profile-sidebar a i {
        margin-right: 10px;
    }

    .profile-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e5e7eb;
    }

    .profile-photo-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
    }
    .profile-photo-wrapper img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #e5e7eb;
    }
    .camera-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #4f46e5;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border: 3px solid #fff;
        cursor: pointer;
    }

    .form-control {
        padding: 12px 14px;
        border-radius: 8px;
    }

    .btn-primary-custom {
        background: #4f46e5;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        color: #fff;
        font-weight: 600;
    }
</style>

<div class="container-fluid px-4">
    <!--<ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #4f46e5;">Dashboard</a></li>
        <li class="breadcrumb-item active">Account Settings</li>
    </ol>-->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(!$admin)
        <div class="alert alert-danger">
            <h4>Error</h4>
            <p>Unable to load admin profile. Please login again.</p>
            <a href="{{ route('auth') }}" class="btn btn-primary-custom">Login</a>
        </div>
    @else

    <div class="row">
        <!-- LEFT SIDEBAR -->
        <div class="col-md-3">
            <div class="profile-sidebar">
                <a class="active"><i class="fas fa-user"></i> Profile Settings</a>
                <a data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-lock"></i> Password
                </a>
                <!--<a><i class="fas fa-bell"></i> Notifications</a>
                <a><i class="fas fa-check-circle"></i> Verification</a>-->
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9">
            <div class="profile-card">

                <div class="d-flex align-items-center mb-4">
                    <div class="profile-photo-wrapper">
                        @if($admin->profile_photo)
                            <img src="{{ asset('storage/profile_photos/'.$admin->profile_photo) }}" alt="Profile Photo">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=6366f1&color=fff">
                        @endif

                        <a href="{{ route('admin.account.edit') }}" class="camera-btn">
                            <i class="fas fa-camera"></i>
                        </a>
                    </div>

                    <div class="ms-4">
                        <h3 class="mb-1">{{ $admin->name }}</h3>
                        <p class="text-muted mb-2">{{ $admin->email }}</p>
                        <span class="badge bg-primary">Administrator</span>
                    </div>
                </div>

                <hr>

                <div class="row g-4 mt-1">

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Full Name</label>
                        <input class="form-control" value="{{ $admin->name }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Email Address</label>
                        <input class="form-control" value="{{ $admin->email }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Member Since</label>
                        <input class="form-control" 
                               value="{{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Last Active</label>
                        <input class="form-control"
                               value="{{ $admin->updated_at ? $admin->updated_at->format('M d, Y') : 'N/A' }}" disabled>
                    </div>

                    <div class="col-12 mt-3">
                        <a href="{{ route('admin.account.edit') }}" class="btn btn-primary-custom">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>

    @endif
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="background:#4f46e5; color:#fff;">
                <h5 class="modal-title"><i class="fas fa-key me-2"></i>Change Password</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.account.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control mb-3" required>

                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control mb-3" required>

                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control mb-1" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary-custom">Update Password</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
