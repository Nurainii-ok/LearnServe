@extends('layouts.member')

@section('title', 'E-Learning')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
}

.page-header {
    background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.course-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    border: none;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.course-image {
    height: 200px;
    background: linear-gradient(45deg, var(--primary-gold), var(--soft-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.course-image i {
    font-size: 3rem;
    color: white;
    opacity: 0.8;
}

.course-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255,255,255,0.9);
    color: var(--primary-brown);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.course-content {
    padding: 1.5rem;
}

.course-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-brown);
    margin-bottom: 0.5rem;
}

.course-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.course-meta i {
    color: var(--primary-gold);
}

.btn-start-learning {
    background: var(--primary-brown);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.btn-start-learning:hover {
    background: var(--deep-brown);
    color: white;
    transform: translateY(-1px);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.empty-state i {
    font-size: 4rem;
    color: var(--primary-gold);
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
}

.btn-browse {
    background: var(--primary-gold);
    color: var(--primary-brown);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-browse:hover {
    background: var(--soft-gold);
    color: var(--deep-brown);
    text-decoration: none;
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="mb-2">E-Learning Dashboard</h1>
        <p class="mb-0">Access your enrolled courses and start learning</p>
    </div>

    @if($enrollments->count() > 0)
        <div class="row g-4">
            @foreach($enrollments as $enrollment)
                <div class="col-lg-4 col-md-6">
                    <div class="course-card">
                        <div class="course-image">
                            <i class="bx {{ $enrollment->type === 'class' ? 'bx-book-open' : 'bx-graduation' }}"></i>
                            <div class="course-badge">
                                {{ $enrollment->type === 'class' ? 'Class' : 'Bootcamp' }}
                            </div>
                        </div>
                        
                        <div class="course-content">
                            @if($enrollment->type === 'class' && $enrollment->class)
                                <h5 class="course-title">{{ $enrollment->class->title }}</h5>
                                <div class="course-meta">
                                    <span><i class="bx bx-user"></i> {{ $enrollment->class->tutor->name ?? 'Instructor' }}</span>
                                    <span><i class="bx bx-time"></i> {{ $enrollment->class->duration ?? 'Flexible' }}</span>
                                </div>
                                <p class="text-muted mb-3">{{ Str::limit($enrollment->class->description, 100) }}</p>
                                <a href="{{ route('elearning.class', $enrollment->class->id) }}" class="btn-start-learning">
                                    <i class="bx bx-play-circle"></i>
                                    Start Learning
                                </a>
                            @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                <h5 class="course-title">{{ $enrollment->bootcamp->title }}</h5>
                                <div class="course-meta">
                                    <span><i class="bx bx-user"></i> {{ $enrollment->bootcamp->tutor->name ?? 'Instructor' }}</span>
                                    <span><i class="bx bx-time"></i> {{ $enrollment->bootcamp->duration ?? 'Flexible' }}</span>
                                </div>
                                <p class="text-muted mb-3">{{ Str::limit($enrollment->bootcamp->description, 100) }}</p>
                                <a href="{{ route('elearning.bootcamp', $enrollment->bootcamp->id) }}" class="btn-start-learning">
                                    <i class="bx bx-play-circle"></i>
                                    Start Learning
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="bx bx-book-open"></i>
            <h3>No Enrolled Courses</h3>
            <p>You haven't enrolled in any courses yet. Browse our available courses and start your learning journey!</p>
            <a href="{{ route('learning') }}" class="btn-browse">Browse Courses</a>
        </div>
    @endif
</div>
@endsection