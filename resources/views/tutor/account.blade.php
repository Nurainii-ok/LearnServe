@extends('layouts.tutor')

@section('title', 'Profile & Settings')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
/* Override conflicting CSS from admin.css */
.main-content {
    margin-left: 0 !important;
}

header {
    position: relative !important;
    left: auto !important;
    width: 100% !important;
    top: auto !important;
    z-index: auto !important;
}

.page-container {
    padding: 1rem 0;
}
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Profile & Settings</h2>
        </div>
        <div class="card-body" style="padding: 2rem; text-align: center;">
            <div style="color: #666;">
                <span class="las la-user-circle" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></span>
                <h3>Account Settings</h3>
                <p>Manage your profile, preferences, and account settings. This feature is coming soon.</p>
            </div>
        </div>
</div>
@endsection