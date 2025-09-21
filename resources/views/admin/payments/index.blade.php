@extends('layouts.admin')

@section('title', 'Payments Management')

@section('styles')
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

.page-container {
    padding: 2rem;
    margin: 0;
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

.status-completed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.status-pending {
    background: rgba(236, 172, 87, 0.1);
    color: var(--primary-gold);
}

.status-failed {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-red);
}

.status-refunded {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
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

.amount {
    font-weight: 600;
    color: var(--primary-brown);
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
</style>
@endsection

@section('content')
<div class="page-container">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="las la-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    <div class="data-table-container">
        <div class="table-header">
            <h2>Payments Management</h2>
            <a href="{{ route('admin.payments.create') }}" class="btn-primary">
                <i class="las la-plus"></i> Add New Payment
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: var(--success-green); padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                {{ session('success') }}
            </div>
        @endif

        @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Member</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <strong>{{ $payment->transaction_id }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $payment->user->name }}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.75rem;">{{ $payment->user->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($payment->class)
                                            <strong>{{ $payment->class->title }}</strong>
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">by {{ $payment->class->tutor->name ?? 'Unknown Tutor' }}</div>
                                        @elseif($payment->bootcamp)
                                            <strong>{{ $payment->bootcamp->title }}</strong>
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">by {{ $payment->bootcamp->tutor->name ?? 'Unknown Tutor' }}</div>
                                        @else
                                            <span class="text-muted">Course not found</span>
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">Course may have been deleted</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="amount">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>
                                    <span class="status-badge status-{{ $payment->status }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') : '-' }}
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn-edit">
                                            <i class="las la-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this payment?')">
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

            <div class="pagination-container">
                {{ $payments->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="las la-credit-card"></i>
                <h3>No payments found</h3>
                <p>No payments have been recorded yet. <a href="{{ route('admin.payments.create') }}" style="color: var(--primary-brown);">Create the first payment</a></p>
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