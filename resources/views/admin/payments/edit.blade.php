@extends('layouts.admin')

@section('title', 'Edit Payment')

@section('styles')
<style>
.page-container {
    padding: 2rem;
    margin: 0;
    max-width: 1200px;
    margin: 0 auto;
}

.form-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.form-header {
    background: var(--light-cream);
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-header h2 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.25rem;
    font-weight: 600;
}

.back-btn {
    background: var(--primary-brown);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s;
}

.back-btn:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.form-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
}

.form-control:disabled {
    background: #f9fafb;
    color: #6b7280;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.error-message {
    color: var(--error-red);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: var(--deep-brown);
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6b7280;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-secondary:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-bottom: 1rem;
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

.readonly-info {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
}

.readonly-info h4 {
    margin: 0 0 0.5rem 0;
    color: var(--primary-brown);
    font-size: 0.875rem;
}

.readonly-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="form-container">
        <div class="form-header">
            <h2>Edit Payment: {{ $payment->transaction_id }}</h2>
            <a href="{{ route('admin.payments') }}" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Payments
            </a>
        </div>

        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST" class="form-body">
            @csrf
            @method('PUT')
            
            <div class="status-badge status-{{ $payment->status }}">
                Current Status: {{ ucfirst($payment->status) }}
            </div>

            <div class="readonly-info">
                <h4>Transaction Information</h4>
                <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                <p><strong>Created:</strong> {{ $payment->created_at->format('M d, Y H:i') }}</p>
                @if($payment->payment_date)
                    <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y H:i') }}</p>
                @endif
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="user_id">Member *</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Select a member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('user_id', $payment->user_id) == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="class_id">Class *</label>
                    <select id="class_id" name="class_id" class="form-control" required>
                        <option value="">Select a class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $payment->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->title }} - Rp{{ number_format($class->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="amount">Amount (Rp) *</label>
                    <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" min="0" step="0.01" required>
                    @error('amount')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method *</label>
                    <select id="payment_method" name="payment_method" class="form-control" required>
                        <option value="">Select payment method</option>
                        <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="debit_card" {{ old('payment_method', $payment->payment_method) == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                        <option value="e_wallet" {{ old('payment_method', $payment->payment_method) == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                    @error('payment_method')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                @error('status')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control" placeholder="Additional notes about the payment">{{ old('notes', $payment->notes) }}</textarea>
                @error('notes')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.payments') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status change confirmation
    const statusSelect = document.getElementById('status');
    const originalStatus = '{{ $payment->status }}';
    
    statusSelect.addEventListener('change', function() {
        if (this.value !== originalStatus) {
            if (this.value === 'refunded') {
                if (!confirm('Are you sure you want to mark this payment as refunded? This action should be carefully considered.')) {
                    this.value = originalStatus;
                }
            }
        }
    });
});
</script>
@endsection