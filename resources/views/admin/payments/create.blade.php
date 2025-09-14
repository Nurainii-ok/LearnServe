@extends('layouts.admin')

@section('title', 'Add New Payment')

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
<div class="page-container">
    <div class="form-container">
        <div class="form-header">
            <h2>Add New Payment</h2>
            <a href="{{ route('admin.payments') }}" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Payments
            </a>
        </div>

        <form action="{{ route('admin.payments.store') }}" method="POST" class="form-body">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label for="user_id">Member *</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Select a member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('user_id') == $member->id ? 'selected' : '' }}>
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
                            <option value="{{ $class->id }}" data-price="{{ $class->price }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                    <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount') }}" min="0" step="0.01" required>
                    @error('amount')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method *</label>
                    <select id="payment_method" name="payment_method" class="form-control" required>
                        <option value="">Select payment method</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                        <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                    @error('payment_method')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="transaction_id">Transaction ID *</label>
                <input type="text" id="transaction_id" name="transaction_id" class="form-control" value="{{ old('transaction_id', 'TXN' . time() . rand(100, 999)) }}" required>
                @error('transaction_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control" placeholder="Additional notes about the payment">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.payments') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Create Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus first input
    document.getElementById('user_id').focus();
    
    // Auto-fill amount when class is selected
    const classSelect = document.getElementById('class_id');
    const amountInput = document.getElementById('amount');
    
    classSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        
        if (price) {
            amountInput.value = price;
        }
    });
    
    // Generate new transaction ID button
    const transactionInput = document.getElementById('transaction_id');
    const generateBtn = document.createElement('button');
    generateBtn.type = 'button';
    generateBtn.innerHTML = '<i class="las la-refresh"></i>';
    generateBtn.style.cssText = 'position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: var(--primary-gold); color: white; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer;';
    
    transactionInput.parentNode.style.position = 'relative';
    transactionInput.parentNode.appendChild(generateBtn);
    
    generateBtn.addEventListener('click', function() {
        transactionInput.value = 'TXN' + Date.now() + Math.floor(Math.random() * 1000);
    });
});
</script>
@endsection