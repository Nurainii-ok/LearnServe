@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid px-4">

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<style>
.profile-wrapper {
    background: #fff;
    border-radius: 14px;
    padding: 32px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #ececec;
}
.profile-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.role-badge {
    background: #4c64ff;
    color: white;
    padding: 5px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}
.btn-save {
    width: 180px;
    padding: 12px;
    font-weight: 600;
    border-radius: 8px;
}
</style>


<div class="d-flex justify-content-center mt-4" style="padding-top: 50px;">
    <div class="col-xl-9">
        <div class="profile-wrapper">

            <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Top Section Profile -->
                <div class="d-flex align-items-center gap-4 mb-5">
                    <div class="profile-img">
                        @if($admin->profile_photo)
                            <img src="{{ asset('storage/profile_photos/' . $admin->profile_photo) }}" alt="Profile Photo">
                        @else
                            <img src="{{ asset('assets/images/default-avatar.png') }}" alt="Default">
                        @endif
                    </div>

                    <div>
                        <h3 class="mb-1">{{ $admin->name }}</h3>
                        <p class="text-secondary mb-2">{{ $admin->email }}</p>
                        <span class="role-badge">Administrator</span>
                    </div>
                </div>

                <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control"
                            name="name" value="{{ old('name', $admin->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control"
                            name="email" value="{{ old('email', $admin->email) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Member Since</label>
                        <input type="text" class="form-control"
                            value="{{ $admin->created_at->format('M d, Y') }}" readonly>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Last Active</label>
                        <input type="text" class="form-control"
                            value="{{ $admin->updated_at->format('M d, Y') }}" readonly>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-save">
                    Save Changes
                </button>
            </form>

        </div>
    </div>
</div>

</div>

@endsection
