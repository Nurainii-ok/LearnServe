@extends('layouts.admin')

@section('title', 'Classes Management')

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
    color: white;
    text-decoration: none;
}

.btn-edit {
    background: var(--primary-gold);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.btn-delete {
    background: #ef4444;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    background: #f8fafc;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.data-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

.alert {
    padding: 1rem;
    margin: 1rem 2rem;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-inactive {
    background: #fef3c7;
    color: #92400e;
}

.status-completed {
    background: #e0e7ff;
    color: #3730a3;
}

.pagination-wrapper {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f8fafc;
}
</style>
@endsection

@section('content')
<div class="page-container">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="las la-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <h1>Classes Management</h1>
        <p>Manage all classes, schedules, and educational content.</p>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h2>All Classes ({{ $classes->total() }})</h2>
            <a href="{{ route('admin.classes.create') }}" class="btn-primary">
                <i class="las la-plus-circle"></i>
                Create New Class
            </a>
        </div>
        
        @if($classes->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Tutor</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                    <tr>
                        <td>#{{ $class->id }}</td>
                        <td>
                            <div>
                                <div style="font-weight: 500;">{{ $class->title }}</div>
                                <small style="color: #6b7280;">{{ Str::limit($class->description, 50) }}</small>
                            </div>
                        </td>
                        <td>{{ $class->tutor->name ?? 'N/A' }}</td>
                        <td>{{ $class->enrolled }}/{{ $class->capacity }}</td>
                        <td>Rp{{ number_format($class->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ $class->status }}">
                                {{ ucfirst($class->status) }}
                            </span>
                        </td>
                        <td>{{ $class->start_date->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn-edit">
                                    <i class="las la-edit"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this class?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="las la-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($classes->hasPages())
        <div class="pagination-wrapper">
            {{ $classes->links() }}
        </div>
        @endif
        
        @else
        <div style="padding: 3rem; text-align: center; color: #6b7280;">
            <i class="las la-graduation-cap" style="font-size: 4rem; display: block; margin-bottom: 1rem; opacity: 0.6;"></i>
            <h3 style="margin: 0 0 1rem 0; color: var(--text-primary);">No Classes Found</h3>
            <p>No classes have been created yet. <a href="{{ route('admin.classes.create') }}" style="color: var(--primary-brown);">Create the first class</a></p>
        </div>
        @endif
    </div>
</div>
@endsection