@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #944e25;">Edit Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #944e25;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.account') }}" style="color: #944e25;">Account Settings</a></li>
        <li class="breadcrumb-item active">Edit Profile</li>
    </ol>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!$admin)
        <div class="alert alert-danger">
            <h4>Access Error</h4>
            <p>Unable to load account information. Please try logging in again.</p>
            <a href="{{ route('auth') }}" class="btn btn-primary">Login</a>
        </div>
    @else

    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Profile Photo Section -->
            <div class="card mb-4 shadow-sm" style="border-color: #ecac57; border-width: 2px;">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #944e25, #6b3419); color: white;">
                    <i class="fas fa-camera me-2"></i>
                    <strong>Profile Photo</strong>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($admin->profile_photo)
                            <img src="{{ asset('storage/profile_photos/' . $admin->profile_photo) }}" 
                                 alt="Current Profile Photo" 
                                 class="rounded-circle border shadow"
                                 style="width: 150px; height: 150px; object-fit: cover; border-color: #ecac57 !important; border-width: 4px !important;">
                        @else
                            <div class="rounded-circle border shadow d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 150px; height: 150px; background: linear-gradient(135deg, #944e25, #ecac57); border-color: #ecac57 !important; border-width: 4px !important;">
                                <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    <p class="text-muted mb-0">Upload a new profile photo to personalize your account</p>
                </div>
            </div>
            <!-- Profile Information Section -->
            <div class="card mb-4 shadow-sm" style="border-color: #ecac57; border-width: 2px;">
                <div class="card-header" style="background: linear-gradient(135deg, #ecac57, #f4d084); color: #944e25;">
                    <i class="fas fa-user-edit me-2"></i>
                    <strong>Edit Profile Information</strong>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Profile Photo Upload -->
                        <div class="mb-4">
                            <label for="profile_photo" class="form-label">
                                <i class="fas fa-camera me-1" style="color: #944e25;"></i>
                                Profile Photo
                            </label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Choose a JPEG, PNG, JPG, or GIF file. Maximum size: 2MB.
                            </div>
                            @error('profile_photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-1" style="color: #944e25;"></i>
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $admin->name ?? '') }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1" style="color: #944e25;"></i>
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Read-only Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-shield-alt me-1" style="color: #944e25;"></i>
                                        Role
                                    </label>
                                    <input type="text" class="form-control" value="Administrator" readonly 
                                           style="background-color: #f8f9fa; border-color: #e9ecef;">
                                    <div class="form-text">
                                        <i class="fas fa-lock me-1"></i>
                                        Role cannot be changed for security reasons.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt me-1" style="color: #944e25;"></i>
                                        Member Since
                                    </label>
                                    <input type="text" class="form-control" value="{{ $admin->created_at->format('M d, Y') }}" readonly 
                                           style="background-color: #f8f9fa; border-color: #e9ecef;">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0" style="background-color: #e8f4f8; border-left: 4px solid #944e25 !important;">
                            <i class="fas fa-info-circle me-2" style="color: #944e25;"></i>
                            <strong style="color: #944e25;">Important:</strong> 
                            Changes to your profile will take effect immediately. Make sure all information is accurate before saving.
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <a href="{{ route('admin.account') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Account
                            </a>
                            <button type="submit" class="btn text-white px-4" style="background-color: #944e25;">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
// Image preview functionality
document.getElementById('profile_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Find the profile image container
            const imgContainer = document.querySelector('.card-body .mb-4');
            if (imgContainer) {
                imgContainer.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Preview" 
                         class="rounded-circle border shadow"
                         style="width: 150px; height: 150px; object-fit: cover; border-color: #ecac57 !important; border-width: 4px !important;">
                    <p class="text-muted mt-3 mb-0">Preview - Save changes to update your profile photo</p>
                `;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection