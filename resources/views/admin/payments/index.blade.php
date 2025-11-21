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
    padding: 0px;
    margin: 0;
    padding-top: 70px; /* Atur sesuai tinggi header */

}

.data-table-container {
    background: white;
    border-radius: 12px;
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

/* PAGINATION ARROW FIX - FORCE OVERRIDE */
.pagination-container .pagination .page-link svg,
.pagination .page-link svg {
    width: 12px !important;
    height: 12px !important;
    max-width: 12px !important;
    max-height: 12px !important;
}

.pagination .page-link {
    font-size: 14px !important;
    padding: 8px 12px !important;
    min-width: 36px !important;
    height: 36px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Hide text and show only small arrows */
.pagination .page-link[aria-label*="Previous"],
.pagination .page-link[aria-label*="Next"] {
    font-size: 0 !important;
    position: relative !important;
}

.pagination .page-link[aria-label*="Previous"]::after {
    content: "‹" !important;
    font-size: 16px !important;
    font-weight: bold !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
}

.pagination .page-link[aria-label*="Next"]::after {
    content: "›" !important;
    font-size: 16px !important;
    font-weight: bold !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
}

/* Force hide any SVG or icon inside pagination arrows */
.pagination .page-link[aria-label*="Previous"] svg,
.pagination .page-link[aria-label*="Next"] svg,
.pagination .page-link[aria-label*="Previous"] i,
.pagination .page-link[aria-label*="Next"] i {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
}

/* NUCLEAR OPTION - Force override ALL pagination arrows */
.pagination .page-link * {
    font-size: 14px !important;
    max-width: 14px !important;
    max-height: 14px !important;
}

/* Target Laravel's default pagination arrows specifically */
.pagination .page-link:first-child,
.pagination .page-link:last-child {
    font-size: 0 !important;
    text-indent: -9999px !important;
    overflow: hidden !important;
    position: relative !important;
    width: 36px !important;
    height: 36px !important;
}

.pagination .page-link:first-child::before {
    content: "‹" !important;
    font-size: 18px !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    text-indent: 0 !important;
    color: currentColor !important;
}

.pagination .page-link:last-child::before {
    content: "›" !important;
    font-size: 18px !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    text-indent: 0 !important;
    color: currentColor !important;
}

/* Hide all children of arrow links */
.pagination .page-link:first-child > *,
.pagination .page-link:last-child > * {
    display: none !important;
    visibility: hidden !important;
    position: absolute !important;
    left: -9999px !important;
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

.midtrans-info {
    color: var(--text-secondary);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.transaction-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.auto-sync-badge {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
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
            <h2>Payment Management</h2>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <button onclick="syncAllPending()" 
                        class="btn-primary" 
                        style="background: var(--primary-gold); padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="las la-sync-alt"></i> Sync All Pending
                </button>
                <div style="color: var(--text-secondary); font-size: 0.875rem;">
                    <i class="las la-sync-alt"></i> Auto-synchronized with Midtrans
                </div>
            </div>
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
                                    <div>
                                        <strong>{{ $payment->transaction_id }}</strong>
                                        @if($payment->midtrans_transaction_id && $payment->midtrans_transaction_id !== $payment->transaction_id)
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                                Midtrans: {{ $payment->midtrans_transaction_id }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $payment->full_name ?: ($payment->user ? $payment->user->name : 'Guest') }}</strong>
                                        <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                            {{ $payment->email ?: ($payment->user ? $payment->user->email : 'No email') }}
                                        </div>
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
                                    <div>
                                        <span class="amount">Rp{{ number_format($payment->midtrans_gross_amount ?: $payment->amount, 0, ',', '.') }}</span>
                                        @if($payment->midtrans_gross_amount && $payment->midtrans_gross_amount != $payment->amount)
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                                Original: Rp{{ number_format($payment->amount, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $payment->payment_method }}
                                        @if($payment->midtrans_bank)
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                                {{ strtoupper($payment->midtrans_bank) }}
                                            </div>
                                        @endif
                                        @if($payment->midtrans_va_number)
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                                VA: {{ $payment->midtrans_va_number }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="status-badge status-{{ $payment->status }}">
                                            {{ $payment->status === 'completed' ? 'Settlement' : ucfirst($payment->status) }}
                                        </span>
                                        @if($payment->midtrans_fraud_status)
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                                Fraud: {{ ucfirst($payment->midtrans_fraud_status) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($payment->midtrans_settlement_time)
                                            <strong>{{ \Carbon\Carbon::parse($payment->midtrans_settlement_time)->format('d M Y, H:i') }}</strong>
                                        @elseif($payment->payment_date)
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}
                                        @elseif($payment->midtrans_transaction_time)
                                            {{ \Carbon\Carbon::parse($payment->midtrans_transaction_time)->format('d M Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                        @if($payment->midtrans_transaction_time && $payment->midtrans_settlement_time)
                                            <div style="color: var(--text-secondary); font-size: 0.75rem;">
                                                Created: {{ \Carbon\Carbon::parse($payment->midtrans_transaction_time)->format('d M Y, H:i') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <button onclick="syncPayment('{{ $payment->transaction_id }}')" 
                                                class="btn-sync" 
                                                title="Sync with Midtrans"
                                                style="background: var(--primary-gold); color: white; border: none; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-size: 0.75rem;">
                                            <i class="las la-sync-alt"></i>
                                        </button>
                                        <button onclick="checkPaymentStatus('{{ $payment->transaction_id }}')" 
                                                class="btn-check" 
                                                title="Check Status"
                                                style="background: var(--text-secondary); color: white; border: none; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-size: 0.75rem;">
                                            <i class="las la-search"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                @if ($payments->hasPages())
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination" style="margin: 0;">
                            {{-- Previous Number --}}
                            @if ($payments->currentPage() > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->url($payments->currentPage() - 1) }}" 
                                       style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; margin: 0 2px; border-radius: 6px;">
                                        {{ $payments->currentPage() - 1 }}
                                    </a>
                                </li>
                            @endif

                            {{-- Current Page --}}
                            <li class="page-item active">
                                <span class="page-link" 
                                      style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #944e25; border: 1px solid #944e25; color: white; margin: 0 2px; border-radius: 6px;">
                                    {{ $payments->currentPage() }}
                                </span>
                            </li>

                            {{-- Next Number --}}
                            @if ($payments->currentPage() < $payments->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->url($payments->currentPage() + 1) }}" 
                                       style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; margin: 0 2px; border-radius: 6px;">
                                        {{ $payments->currentPage() + 1 }}
                                    </a>
                                </li>
                            @endif

                            {{-- Show more pages if needed --}}
                            @if ($payments->lastPage() > 3 && $payments->currentPage() < $payments->lastPage() - 1)
                                <li class="page-item">
                                    <span style="padding: 8px 4px;">...</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->url($payments->lastPage()) }}" 
                                       style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; margin: 0 2px; border-radius: 6px;">
                                        {{ $payments->lastPage() }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        @else
            <div class="empty-state">
                <i class="las la-credit-card"></i>
                <h3>No payments found</h3>
                <p>No payments have been recorded yet. Payments will appear here automatically when users make purchases through Midtrans.</p>
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

// Sync payment status with Midtrans
async function syncPayment(orderId) {
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="las la-spinner la-spin"></i>';
    button.disabled = true;
    
    try {
        const response = await fetch(`/payment/sync/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success message
            showNotification('Payment status synced successfully!', 'success');
            
            // Reload page after short delay to show updated status
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Failed to sync payment: ' + result.error, 'error');
        }
    } catch (error) {
        console.error('Sync error:', error);
        showNotification('Network error occurred while syncing', 'error');
    } finally {
        // Restore button state
        button.innerHTML = originalContent;
        button.disabled = false;
    }
}

// Check payment status
async function checkPaymentStatus(orderId) {
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="las la-spinner la-spin"></i>';
    button.disabled = true;
    
    try {
        const response = await fetch(`/payment/status/${orderId}`);
        const result = await response.json();
        
        if (result.error) {
            showNotification('Error: ' + result.error, 'error');
        } else {
            const message = `
                Order ID: ${result.order_id}
                Local Status: ${result.local_status}
                Midtrans Status: ${result.midtrans_status}
                Payment Type: ${result.payment_type || 'N/A'}
                Amount: Rp${result.gross_amount || 'N/A'}
            `;
            
            alert(message);
            
            if (result.synced) {
                showNotification('Status difference detected and synced!', 'success');
                setTimeout(() => window.location.reload(), 1000);
            }
        }
    } catch (error) {
        console.error('Check status error:', error);
        showNotification('Network error occurred while checking status', 'error');
    } finally {
        // Restore button state
        button.innerHTML = originalContent;
        button.disabled = false;
    }
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 9999;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    // Set background color based on type
    if (type === 'success') {
        notification.style.background = 'var(--success-green)';
    } else if (type === 'error') {
        notification.style.background = 'var(--error-red)';
    } else {
        notification.style.background = 'var(--primary-brown)';
    }
    
    notification.innerHTML = `
        <i class="las la-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

// Sync all pending payments
async function syncAllPending() {
    const button = event.target;
    const originalContent = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="las la-spinner la-spin"></i> Syncing...';
    button.disabled = true;
    
    // Get all pending payment order IDs
    const pendingPayments = @json($payments->where('status', 'pending')->pluck('transaction_id'));
    
    if (pendingPayments.length === 0) {
        showNotification('No pending payments to sync', 'info');
        button.innerHTML = originalContent;
        button.disabled = false;
        return;
    }
    
    let successCount = 0;
    let errorCount = 0;
    
    showNotification(`Starting sync for ${pendingPayments.length} pending payments...`, 'info');
    
    // Sync each payment with delay to avoid overwhelming the server
    for (let i = 0; i < pendingPayments.length; i++) {
        const orderId = pendingPayments[i];
        
        try {
            const response = await fetch(`/payment/sync/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                successCount++;
            } else {
                errorCount++;
                console.error(`Failed to sync ${orderId}:`, result.error);
            }
        } catch (error) {
            errorCount++;
            console.error(`Error syncing ${orderId}:`, error);
        }
        
        // Add small delay between requests
        if (i < pendingPayments.length - 1) {
            await new Promise(resolve => setTimeout(resolve, 500));
        }
        
        // Update button text with progress
        button.innerHTML = `<i class="las la-spinner la-spin"></i> Syncing... ${i + 1}/${pendingPayments.length}`;
    }
    
    // Show final result
    if (successCount > 0) {
        showNotification(`Successfully synced ${successCount} payments!`, 'success');
        if (errorCount > 0) {
            showNotification(`${errorCount} payments failed to sync`, 'error');
        }
        
        // Reload page after short delay
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        showNotification('No payments were synced successfully', 'error');
    }
    
    // Restore button state
    button.innerHTML = originalContent;
    button.disabled = false;
}

// Add CSRF token to page if not exists
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.head.appendChild(meta);
}

// FORCE FIX PAGINATION ARROWS - JAVASCRIPT APPROACH
function fixPaginationArrows() {
    // Find all pagination arrow links
    const paginationLinks = document.querySelectorAll('.pagination .page-link');
    
    paginationLinks.forEach(link => {
        // Check if it's a previous/next arrow by looking for SVG or specific text
        const svg = link.querySelector('svg');
        const text = link.textContent.trim();
        
        if (svg || text.includes('Previous') || text.includes('Next') || text.includes('‹') || text.includes('›')) {
            // Clear all content
            link.innerHTML = '';
            
            // Add appropriate arrow
            if (text.includes('Previous') || text.includes('‹') || link.getAttribute('aria-label')?.includes('Previous')) {
                link.innerHTML = '‹';
            } else if (text.includes('Next') || text.includes('›') || link.getAttribute('aria-label')?.includes('Next')) {
                link.innerHTML = '›';
            }
            
            // Force styling
            link.style.fontSize = '18px';
            link.style.fontWeight = 'bold';
            link.style.width = '36px';
            link.style.height = '36px';
            link.style.display = 'flex';
            link.style.alignItems = 'center';
            link.style.justifyContent = 'center';
        }
    });
}

// Run on page load
document.addEventListener('DOMContentLoaded', fixPaginationArrows);

// Run after any AJAX updates (if applicable)
setTimeout(fixPaginationArrows, 100);
setTimeout(fixPaginationArrows, 500);
</script>
@endsection