@extends('layouts.tutor')

@section('title', 'My Classes')

@section('styles')
<style>
    .page-container {
        padding: 1rem 0;
    }
    .btn-action {
        background: var(--primary-brown);
        color: #fff;
        padding: 0.7rem 1.2rem;
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        background: #8c5a3d; /* lebih gelap sedikit saat hover */
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">My Classes</h2>
            <button class="btn-action">
                <i class="las la-plus"></i> Create New Class
            </button>
        </div>
        <div class="card-body text-center" style="padding: 2rem;">
            <div style="color: #666;">
                <span class="las la-chalkboard-teacher" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></span>
                <h3>Classes Management</h3>
                <p>This feature is coming soon. You'll be able to manage all your classes here.</p>
            </div>
        </div>
    </div>
</div>
@endsection
