@extends('layouts.tutor')

@section('title', 'Profile & Settings')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #944e25;">Profile & Settings</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('tutor.dashboard') }}" style="color: #944e25;">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile & Settings</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-xl-8">
            <!-- Profile Photo & Basic Info -->
            <div class="card mb-4" style="border-color: #ecac57;">
                <div class="card-header" style="background-color: #944e25; color: white;">
                    <i class="fas fa-user me-1"></i>
                    Profile Information
                    <a href="{{ route('tutor.account.edit') }}" class="btn btn-sm btn-light float-end">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                        <!-- Profile Photo -->
                        <div class="col-md-3 text-center">
                            <div class="position-relative d-inline-block">
                                @if($tutor && $tutor->profile_photo)
                                    <img src="{{ asset('storage/profile_photos/' . $tutor->profile_photo) }}" 
                                         alt="Profile Photo" 
                                         class="rounded-circle border shadow"
                                         style="width: 120px; height: 120px; object-fit: cover; border-color: #ecac57 !important; border-width: 3px !important;">
                                @else
                                    <div class="rounded-circle border shadow d-flex align-items-center justify-content-center"
                                         style="width: 120px; height: 120px; background: linear-gradient(135deg, #944e25, #ecac57); border-color: #ecac57 !important; border-width: 3px !important;">
                                        <i class="fas fa-chalkboard-teacher text-white" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 end-0">
                                    <a href="{{ route('tutor.account.edit') }}" class="btn btn-sm text-white rounded-circle shadow" style="background-color: #944e25; width: 35px; height: 35px; padding: 0;">
                                        <i class="fas fa-camera" style="font-size: 12px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Basic Info -->
                        <div class="col-md-9">
                            <h3 class="mb-2" style="color: #944e25;">{{ $tutor->name }}</h3>
                            <p class="text-muted mb-2">{{ $tutor->email }}</p>
                            <span class="badge px-3 py-2" style="background-color: #944e25; font-size: 0.9rem;">
                                <i class="fas fa-chalkboard-teacher me-1"></i>Tutor
                            </span>
                        </div>
                    </div>
                    
                    <!-- Detailed Information -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="border-start border-3 ps-3 mb-3" style="border-color: #944e25 !important;">
                                <label class="form-label text-muted small fw-bold">FULL NAME</label>
                                <p class="h6 mb-0">{{ $tutor->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-3 ps-3 mb-3" style="border-color: #ecac57 !important;">
                                <label class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                                <p class="h6 mb-0">{{ $tutor->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-3 ps-3 mb-3" style="border-color: #944e25 !important;">
                                <label class="form-label text-muted small fw-bold">MEMBER SINCE</label>
                                <p class="h6 mb-0">{{ $tutor->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-3 ps-3 mb-3" style="border-color: #ecac57 !important;">
                                <label class="form-label text-muted small fw-bold">LAST ACTIVE</label>
                                <p class="h6 mb-0">{{ $tutor->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="card mb-4" style="border-color: #ecac57;">
                <div class="card-header" style="background-color: #944e25; color: white;">
                    <i class="fas fa-shield-alt me-1"></i>
                    Security Settings
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background-color: #f8f9fa; border-left: 4px solid #944e25;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #944e25;">
                                    <i class="fas fa-key text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: #944e25;">Password Security</h6>
                                <p class="text-muted mb-0 small">Last updated: {{ $tutor->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn text-white" style="background-color: #944e25;" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-edit me-1"></i>Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutor Statistics & Quick Actions -->
        <div class="col-xl-4">
            <!-- Teaching Overview -->
            <div class="card mb-4 shadow-sm" style="border-color: #ecac57; border-width: 2px;">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #ecac57, #f4d084); color: #944e25;">
                    <i class="fas fa-chart-line me-2" style="font-size: 1.2rem;"></i>
                    <strong>Teaching Overview</strong>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #944e25, #6b3419);">
                            <i class="fas fa-chalkboard-teacher text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #944e25;">Tutor Dashboard</h4>
                        <p class="text-muted small mb-0">Educational Instructor</p>
                    </div>
                    
                    <!-- Statistics Grid -->
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded" style="background-color: #f8f9fa; border-left: 3px solid #944e25;">
                                <h4 class="mb-1 fw-bold" style="color: #944e25;">{{ $totalClasses }}</h4>
                                <small class="text-muted">Classes</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded" style="background-color: #f8f9fa; border-left: 3px solid #ecac57;">
                                <h4 class="mb-1 fw-bold" style="color: #944e25;">{{ $totalStudents }}</h4>
                                <small class="text-muted">Students</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded" style="background-color: #f8f9fa; border-left: 3px solid #944e25;">
                                <h4 class="mb-1 fw-bold" style="color: #944e25;">${{ number_format($totalEarnings, 0) }}</h4>
                                <small class="text-muted">Total Earnings</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm" style="border-color: #ecac57; border-width: 2px;">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #944e25, #6b3419); color: white;">
                    <i class="fas fa-bolt me-2" style="font-size: 1.2rem;"></i>
                    <strong>Quick Actions</strong>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('tutor.classes') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start p-3 rounded" style="border-color: #944e25; color: #944e25; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#944e25'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#944e25';">
                            <i class="fas fa-graduation-cap me-3" style="font-size: 1.2rem;"></i>
                            <span class="fw-semibold">Manage Classes</span>
                        </a>
                        <a href="{{ route('tutor.tasks') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start p-3 rounded" style="border-color: #944e25; color: #944e25; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#944e25'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#944e25';">
                            <i class="fas fa-tasks me-3" style="font-size: 1.2rem;"></i>
                            <span class="fw-semibold">Manage Tasks</span>
                        </a>
                        <a href="{{ route('tutor.grades') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start p-3 rounded" style="border-color: #944e25; color: #944e25; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#944e25'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#944e25';">
                            <i class="fas fa-star me-3" style="font-size: 1.2rem;"></i>
                            <span class="fw-semibold">Manage Grades</span>
                        </a>
                        <a href="{{ route('tutor.dashboard') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start p-3 rounded" style="border-color: #944e25; color: #944e25; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#944e25'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#944e25';">
                            <i class="fas fa-chart-bar me-3" style="font-size: 1.2rem;"></i>
                            <span class="fw-semibold">View Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #944e25; color: white;">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-key me-1"></i>Change Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tutor.account.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Password must be at least 4 characters long.</div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white" style="background-color: #944e25;">
                        <i class="fas fa-save me-1"></i>Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection