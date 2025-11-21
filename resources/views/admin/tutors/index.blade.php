@extends('layouts.admin')

@section('title', 'Tutors Management')

@section('styles')
<style>
.page-container {
    padding: 0px;
    margin: 0;
}

.page-header {
    background: white;
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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
}

.page-container {
    padding-top: 70px; /* Atur sesuai tinggi header */
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
    margin-bottom: 2rem;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
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
    <!--<div class="page-header">
        <h1>Tutors Management</h1>
        <p>Manage all tutors, view their details, and handle tutor-related operations.</p>
    </div>-->

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h2>All Tutors ({{ $tutors->total() }})</h2>
            <!--<a href="{{ route('admin.tutors.create') }}" class="btn-primary">
                <i class="las la-user-plus"></i>
                Add New Tutor
            </a>-->
        </div>
        
        @if($tutors->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Classes</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tutors as $tutor)
                    <tr>
                        <td>#{{ $tutor->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-gold); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                    {{ strtoupper(substr($tutor->name, 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">{{ $tutor->name }}</span>
                            </div>
                        </td>
                        <td>{{ $tutor->email }}</td>
                        <td>{{ $tutor->classesAsTeacher->count() ?? 0 }}</td>
                        <td>{{ $tutor->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <!--<a href="{{ route('admin.tutors.edit', $tutor->id) }}" class="btn-edit">
                                    <i class="las la-edit"></i>
                                    Edit
                                </a>-->
                                <form action="{{ route('admin.tutors.destroy', $tutor->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this tutor? This will also remove all their classes.')">
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
        @if($tutors->hasPages())
        <div class="pagination-wrapper">
            {{ $tutors->links() }}
        </div>
        @endif
        
        @else
        <div style="padding: 3rem; text-align: center; color: #6b7280;">
            <i class="las la-chalkboard-teacher" style="font-size: 4rem; display: block; margin-bottom: 1rem; opacity: 0.6;"></i>
            <h3 style="margin: 0 0 1rem 0; color: var(--text-primary);">No Tutors Found</h3>
            <p>No tutors have been registered yet. <a href="{{ route('admin.tutors.create') }}" style="color: var(--primary-brown);">Add the first tutor</a></p>
        </div>
        @endif
    </div>
</div>
@endsection