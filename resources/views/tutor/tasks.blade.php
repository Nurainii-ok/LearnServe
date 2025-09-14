@extends('layouts.tutor')

@section('title', 'Tasks & Assignments')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
.page-container {
    padding: 1rem 0;
}
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Tasks & Assignments</h2>
            <button class="btn-action" style="background: var(--primary-gold); color: white; padding: 0.7rem 1.2rem; border: none; border-radius: 10px;">
                Create New Task
            </button>
        </div>
        <div class="card-body" style="padding: 2rem; text-align: center;">
            <div style="color: #666;">
                <span class="las la-clipboard-check" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></span>
                <h3>Task Management</h3>
                <p>Create and manage assignments for your students. This feature is coming soon.</p>
            </div>
        </div>
</div>
@endsection