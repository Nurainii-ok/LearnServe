@extends('layouts.tutor')

@section('title', 'My Classes')

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
            <h2>My Classes</h2>
            <button class="btn-action" style="background: var(--primary-brown); color: white; padding: 0.7rem 1.2rem; border: none; border-radius: 10px;">
                Create New Class
            </button>
        </div>
        <div class="card-body" style="padding: 2rem; text-align: center;">
            <div style="color: #666;">
                <span class="las la-chalkboard-teacher" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></span>
                <h3>Classes Management</h3>
                <p>This feature is coming soon. You'll be able to manage all your classes here.</p>
            </div>
        </div>
</div>
@endsection