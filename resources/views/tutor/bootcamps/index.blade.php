@extends('layouts.tutor')

@section('title', 'My Bootcamps')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --success-green: #10b981;
    --error-red: #ef4444;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
}

.dashboard-content {
    padding: 0;
    margin: 0;
    padding-top: 1rem;
}

.data-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.table-header {
    background: var(--light-cream);
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h2 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.25rem;
    font-weight: 600;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
}

.data-table th {
    background: #f9fafb;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 2px solid #e5e7eb;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.status-inactive {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.status-completed {
    background: rgba(148, 78, 37, 0.1);
    color: var(--primary-brown);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-edit {
    background: var(--primary-gold);
    color: white;
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.75rem;
    transition: all 0.3s;
}

.btn-edit:hover {
    background: var(--soft-gold);
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: var(--error-red);
    color: white;
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-delete:hover {
    background: #dc2626;
}

.pagination-container {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f9fafb;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #d1d5db;
}

.student-count {
    font-weight: 600;
    color: var(--primary-brown);
}

.price {
    font-weight: 600;
    color: var(--primary-gold);
}

.duration-badge {
    background: rgba(148, 78, 37, 0.1);
    color: var(--primary-brown);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="data-table-container">
        <div class="table-header">
            <h2>My Bootcamps</h2>
            <a href="{{ route('tutor.bootcamps.create') }}" class="btn-primary">
                <i class="las la-plus"></i> Create New Bootcamp
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: var(--success-green); padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                {{ session('success') }}
            </div>
        @endif

        @if($bootcamps->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Bootcamp Title</th>
                            <th>Students</th>
                            <th>Capacity</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bootcamps as $bootcamp)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $bootcamp->title }}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.25rem;">
                                            {{ Str::limit($bootcamp->description, 50) }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="student-count">{{ $bootcamp->payments_count ?? 0 }}</span>
                                </td>
                                <td>{{ $bootcamp->capacity }}</td>
                                <td>
                                    <span class="duration-badge">{{ $bootcamp->duration }} days</span>
                                </td>
                                <td>
                                    <span class="price">Rp{{ number_format($bootcamp->price, 0, ',', '.') }}</span>
                                </td>
                                <td>{{ $bootcamp->schedule ?? '-' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $bootcamp->status }}">
                                        {{ ucfirst($bootcamp->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('tutor.bootcamps.edit', $bootcamp->id) }}" class="btn-edit">
                                            <i class="las la-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('tutor.bootcamps.destroy', $bootcamp->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this bootcamp?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="las la-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="las la-graduation-cap"></i>
                <h3>No bootcamps found</h3>
                <p>You haven't created any bootcamps yet. Create your first bootcamp to get started!</p>
            </div>
        @endif
    </div>
</div>
@endsection
