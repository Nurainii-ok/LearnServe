@extends('layouts.member')

@section('title', 'My Enrollments')

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
    margin: 0 0 0.5rem 0;
}

.page-header p {
    color: #6b7280;
    margin: 0;
    font-size: 1rem;
}

.enrollment-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.enrollment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.enrollment-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.enrollment-content {
    padding: 1.5rem;
}

.class-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.class-image {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    background: var(--light-cream);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.class-details h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.class-details p {
    margin: 0 0 0.75rem 0;
    color: var(--text-secondary);
    line-height: 1.5;
}

.class-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.meta-item i {
    color: var(--primary-gold);
}

.payment-info {
    text-align: right;
}

.payment-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-brown);
    margin-bottom: 0.25rem;
}

.payment-date {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.status-completed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.empty-state {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: var(--text-secondary);
    opacity: 0.5;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    margin: 0 0 1rem 0;
    color: var(--text-primary);
}

.empty-state p {
    color: var(--text-secondary);
    margin: 0 0 2rem 0;
}

.btn-browse {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-browse:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .enrollment-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .class-info {
        flex-direction: column;
        text-align: center;
    }
    
    .payment-info {
        text-align: center;
    }
    
    .class-meta {
        justify-content: center;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <div class="page-header">
        <h1>My Enrollments</h1>
        <p>Track all your enrolled classes and payment history</p>
    </div>

    @if($enrollments->count() > 0)
        <!-- Enrollments List -->
        @foreach($enrollments as $enrollment)
        <div class="enrollment-card">
            <div class="enrollment-header">
                <div class="class-info">
                    <div class="class-image">
                        @if($enrollment->type === 'class' && $enrollment->class && $enrollment->class->image)
                            <img src="{{ asset($enrollment->class->image) }}" alt="{{ $enrollment->class->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                        @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp && $enrollment->bootcamp->image)
                            <img src="{{ asset($enrollment->bootcamp->image) }}" alt="{{ $enrollment->bootcamp->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                        @else
                            <i class="bx {{ $enrollment->type === 'class' ? 'bx-book' : 'bx-code-alt' }}" style="font-size: 2rem; color: var(--primary-brown);"></i>
                        @endif
                    </div>
                    <div class="class-details">
                        <h3>
                            @if($enrollment->type === 'class' && $enrollment->class)
                                {{ $enrollment->class->title }}
                            @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                {{ $enrollment->bootcamp->title }}
                            @else
                                Course Title
                            @endif
                        </h3>
                        <p>
                            @if($enrollment->type === 'class' && $enrollment->class)
                                {{ Str::limit($enrollment->class->description ?? 'No description available', 150) }}
                            @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                {{ Str::limit($enrollment->bootcamp->description ?? 'No description available', 150) }}
                            @else
                                No description available
                            @endif
                        </p>
                        <div class="class-meta">
                            @if($enrollment->type === 'class' && $enrollment->class && $enrollment->class->tutor)
                            <div class="meta-item">
                                <i class="bx bx-user"></i>
                                <span>{{ $enrollment->class->tutor->name }}</span>
                            </div>
                            @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp && $enrollment->bootcamp->tutor)
                            <div class="meta-item">
                                <i class="bx bx-user"></i>
                                <span>{{ $enrollment->bootcamp->tutor->name }}</span>
                            </div>
                            @endif
                            <div class="meta-item">
                                <i class="bx bx-category"></i>
                                <span>{{ ucfirst($enrollment->type) }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bx bx-calendar"></i>
                                <span>Enrolled: {{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bx bx-trending-up"></i>
                                <span>Progress: {{ number_format($enrollment->progress, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="payment-info">
                    <div class="payment-amount">
                        @if($enrollment->type === 'class' && $enrollment->class)
                            Rp{{ number_format($enrollment->class->price, 0, ',', '.') }}
                        @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                            Rp{{ number_format($enrollment->bootcamp->price, 0, ',', '.') }}
                        @else
                            Free
                        @endif
                    </div>
                    <div class="payment-date">Enrolled on {{ $enrollment->enrolled_at->format('M d, Y') }}</div>
                    <span class="status-badge status-{{ $enrollment->status }}">
                        @if($enrollment->status === 'active')
                            ✓ Active
                        @elseif($enrollment->status === 'completed')
                            🎉 Completed
                        @elseif($enrollment->status === 'dropped')
                            ❌ Dropped
                        @else
                            📋 {{ ucfirst($enrollment->status) }}
                        @endif
                    </span>
                    
                    @if($enrollment->status === 'active')
                    <form action="{{ route('enrollment.unenroll', $enrollment->id) }}" method="POST" style="margin-top: 0.5rem;" onsubmit="return confirm('Are you sure you want to unenroll? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Unenroll</button>
                    </form>
                    @endif
                </div>
            </div>
            
            @if($enrollment->notes)
            <div class="enrollment-content">
                <div style="background: var(--light-cream); padding: 1rem; border-radius: 8px;">
                    <strong style="color: var(--primary-brown);">Notes:</strong>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">{{ $enrollment->notes }}</p>
                </div>
            </div>
            @endif
        </div>
        @endforeach

        <!-- Pagination -->
        @if($enrollments->hasPages())
        <div class="pagination-wrapper">
            {{ $enrollments->links() }}
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="bx bx-book-bookmark"></i>
            <h3>No Enrollments Yet</h3>
            <p>You haven't enrolled in any classes yet. Browse our available classes and start your learning journey!</p>
            <a href="{{ route('learning') }}" class="btn-browse">Browse Classes</a>
        </div>
    @endif
</div>
@endsection