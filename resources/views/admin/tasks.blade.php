@extends('layouts.admin')

@section('title', 'Task Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
    padding: 0;
    margin: 0;
}

.page-header {
    background: white;
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.page-header p {
    color: var(--text-secondary);
    margin: 0.5rem 0 0 0;
}

.content-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin: 0 2rem;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
}

.card-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    background: var(--deep-brown);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(148, 78, 37, 0.3);
}

.card-body {
    padding: 2rem;
}

.feature-placeholder {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-secondary);
}

.feature-icon {
    font-size: 4rem;
    color: var(--primary-gold);
    margin-bottom: 1rem;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.feature-description {
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.feature-list {
    text-align: left;
    max-width: 600px;
    margin: 0 auto;
}

.feature-list h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.feature-list ul {
    list-style: none;
    padding: 0;
}

.feature-list li {
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    color: var(--text-secondary);
}

.feature-list li:before {
    content: '✓';
    color: var(--primary-gold);
    font-weight: bold;
    margin-right: 0.75rem;
    font-size: 1.1rem;
}
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>Task Management</h1>
        <p>Manage administrative tasks, assignments, and workflow operations efficiently.</p>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2>Tasks</h2>
            <a href="#" class="btn-primary" onclick="alert('Create task feature coming soon!')">
                Create New Task
                <i class="las la-plus"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="feature-placeholder">
                <i class="las la-clipboard-list feature-icon"></i>
                <h3 class="feature-title">Task Management System</h3>
                <p class="feature-description">Comprehensive task management system for administrative operations. This feature will enable you to efficiently handle all task-related activities.</p>
                
                <div class="feature-list">
                    <h3>Upcoming Features:</h3>
                    <ul>
                        <li>Create and assign administrative tasks</li>
                        <li>Track task progress and completion status</li>
                        <li>Set deadlines and priority levels</li>
                        <li>Task collaboration and team assignments</li>
                        <li>Automated task notifications and reminders</li>
                        <li>Task reporting and analytics</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection