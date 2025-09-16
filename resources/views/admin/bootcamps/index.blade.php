@extends('layouts.admin')

@section('title', 'Bootcamp Management')

@section('styles')
<style>
.page-container {
    padding: 0;
    margin: 0;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    background: white;
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin: 0 2rem 2rem 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.page-header p {
    color: #6b7280;
    margin: 0;
    font-size: 1rem;
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
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    font-size: 0.75rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    transition: all 0.3s ease;
}

.btn-edit:hover {
    background: #d97435;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-delete {
    background: #ef4444;
    color: white;
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    font-size: 0.75rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    transition: all 0.3s ease;
}

.btn-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
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
    padding: 1.25rem 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
    font-size: 0.9rem;
}

.data-table tbody tr:hover {
    background: #f9fafb;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
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

.level-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.level-beginner {
    background: #dbeafe;
    color: #1e40af;
}

.level-intermediate {
    background: #fef3c7;
    color: #92400e;
}

.level-advanced {
    background: #fecaca;
    color: #dc2626;
}

.pagination-wrapper {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f8fafc;
    display: flex;
    justify-content: center;
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
        <h1>Bootcamp Management</h1>
        <p>Manage intensive bootcamp programs and training courses.</p>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h2>All Bootcamps ({{ $bootcamps->total() }})</h2>
            <a href="{{ route('admin.bootcamps.create') }}" class="btn-primary">
                <i class="las la-plus-circle"></i>
                Create New Bootcamp
            </a>
        </div>
        
        @if($bootcamps->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 250px;">Bootcamp Details</th>
                        <th style="width: 150px;">Tutor</th>
                        <th style="width: 100px;">Enrollment</th>
                        <th style="width: 120px;">Price</th>
                        <th style="width: 100px;">Level</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 120px;">Start Date</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bootcamps as $bootcamp)
                    <tr>
                        <td><strong>#{{ $bootcamp->id }}</strong></td>
                        <td>
                            <div>
                                <div style="font-weight: 600; font-size: 1rem; color: var(--text-primary); margin-bottom: 0.25rem;">
                                    {{ $bootcamp->title }}
                                </div>
                                <div style="color: #6b7280; font-size: 0.875rem; line-height: 1.4;">
                                    {{ Str::limit($bootcamp->description, 60) }}
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    @if($bootcamp->category)
                                    <span style="display: inline-block; background: var(--light-cream); color: var(--primary-brown); padding: 0.125rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500; margin-right: 0.25rem;">
                                        {{ $bootcamp->category }}
                                    </span>
                                    @endif
                                    @if($bootcamp->duration)
                                    <span style="display: inline-block; background: #e0e7ff; color: #3730a3; padding: 0.125rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                        {{ $bootcamp->duration }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-gold); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
                                    {{ strtoupper(substr($bootcamp->tutor->name ?? 'N', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">{{ $bootcamp->tutor->name ?? 'Not assigned' }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $enrolled = $bootcamp->enrolled ?? 0;
                                $capacity = $bootcamp->capacity;
                                $percentage = $capacity > 0 ? ($enrolled / $capacity) * 100 : 0;
                                $statusColor = $percentage >= 90 ? '#ef4444' : ($percentage >= 70 ? '#f59e0b' : '#10b981');
                            @endphp
                            <div style="text-align: center;">
                                <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $enrolled }}/{{ $capacity }}</div>
                                <div style="width: 100%; background: #f3f4f6; border-radius: 4px; height: 6px; overflow: hidden;">
                                    <div style="width: {{ $percentage }}%; background: {{ $statusColor }}; height: 100%; transition: width 0.3s ease;"></div>
                                </div>
                                <small style="color: #6b7280; font-size: 0.75rem;">{{ number_format($percentage, 0) }}% full</small>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--primary-brown);">Rp{{ number_format($bootcamp->price, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            @php
                                $level = $bootcamp->level ?? 'beginner';
                                $levelClass = match($level) {
                                    'beginner' => 'level-beginner',
                                    'intermediate' => 'level-intermediate', 
                                    'advanced' => 'level-advanced',
                                    default => 'level-beginner'
                                };
                            @endphp
                            <span class="level-badge {{ $levelClass }}">
                                {{ ucfirst($level) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $status = $bootcamp->status ?? 'active';
                                $statusClass = match($status) {
                                    'active' => 'status-active',
                                    'inactive' => 'status-inactive', 
                                    'completed' => 'status-completed',
                                    default => 'status-active'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td>{{ $bootcamp->start_date ? $bootcamp->start_date->format('M d, Y') : 'Not set' }}</td>
                        <td>
                            <div style="display: flex; gap: 0.375rem; justify-content: center;">
                                <a href="{{ route('admin.bootcamps.edit', $bootcamp->id) }}" class="btn-edit" title="Edit Bootcamp">
                                    <i class="las la-edit"></i>
                                </a>
                                <form action="{{ route('admin.bootcamps.destroy', $bootcamp->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this bootcamp? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Delete Bootcamp">
                                        <i class="las la-trash"></i>
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
        @if($bootcamps->hasPages())
        <div class="pagination-wrapper">
            {{ $bootcamps->links() }}
        </div>
        @endif
        
        @else
        <div style="padding: 3rem; text-align: center; color: #6b7280;">
            <i class="las la-rocket" style="font-size: 4rem; display: block; margin-bottom: 1rem; opacity: 0.6;"></i>
            <h3 style="margin: 0 0 1rem 0; color: var(--text-primary);">No Bootcamps Found</h3>
            <p>No bootcamps have been created yet. <a href="{{ route('admin.bootcamps.create') }}" style="color: var(--primary-brown);">Create the first bootcamp</a></p>
        </div>
        @endif
    </div>
</div>
@endsection