@extends('layouts.tutor')

@section('title', 'My Classes')

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

.class-thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #e5e7eb;
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
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="data-table-container">
        <div class="table-header">
            <h2>My Classes</h2>
            <a href="{{ route('tutor.classes.create') }}" class="btn-primary">
                <i class="las la-plus"></i> Create New Class
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: var(--success-green); padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                {{ session('success') }}
            </div>
        @endif

        @if($classes->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Class Title</th>
                                    <th>Students</th>
                                    <th>Capacity</th>
                                    <th>Price</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                        </tr>
                    </thead>
                    <tbody>
@foreach($classes as $class)
<tr>

    <!-- Thumbnail -->
    <td>
        @if($class->image)
            <img src="{{ asset('storage/' . $class->image) }}" class="class-thumb">
        @else
            <div style="width:60px;height:60px;background:#f3f4f6;border-radius:8px;display:flex;justify-content:center;align-items:center;border:1px solid #eee;">
                <i class="las la-image" style="font-size:22px;color:#9ca3af;"></i>
            </div>
        @endif
    </td>

    <!-- Class Title -->
    <td>
        <strong>{{ $class->title }}</strong>
        <div style="color: var(--text-secondary); font-size: 0.75rem;">
            {{ Str::limit($class->description, 50) }}
        </div>
    </td>

    <!-- Students -->
    <td><span class="student-count">{{ $class->payments_count ?? 0 }}</span></td>

    <!-- Capacity -->
    <td>{{ $class->capacity }}</td>

    <!-- Price -->
    <td><span class="price">Rp{{ number_format($class->price, 0, ',', '.') }}</span></td>

    <!-- Schedule -->
    <td>{{ $class->schedule ?? 'Not set' }}</td>

    <!-- Status -->
    <td>
        <span class="status-badge status-{{ $class->status }}">{{ ucfirst($class->status) }}</span>
    </td>

    <!-- Actions -->
    <td>
        <div class="action-buttons">
            <a href="{{ route('tutor.classes.edit', $class->id) }}" class="btn-edit">
                <i class="las la-edit"></i> Edit
            </a>
            <form action="{{ route('tutor.classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?')">
                @csrf
                @method('DELETE')
                <button class="btn-delete">
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

            <div class="pagination-container">
                {{ $classes->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="las la-chalkboard-teacher"></i>
                <h3>No classes found</h3>
                <p>You haven't created any classes yet. <a href="{{ route('tutor.classes.create') }}" style="color: var(--primary-brown);">Create your first class</a></p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to table rows
    const rows = document.querySelectorAll('.data-table tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
@endsection