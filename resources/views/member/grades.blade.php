@extends('layouts.member')

@section('title', 'My Grades')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --success-green: #10b981;
    --warning-yellow: #f59e0b;
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

.grade-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.grade-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.grade-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.grade-content {
    padding: 1.5rem;
}

.task-info h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.class-name {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0 0 0.75rem 0;
}

.task-meta {
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

.grade-score {
    text-align: right;
}

.score-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
}

.score-number.excellent { color: var(--success-green); }
.score-number.good { color: var(--warning-yellow); }
.score-number.poor { color: var(--error-red); }

.score-label {
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.score-label.excellent { color: var(--success-green); }
.score-label.good { color: var(--warning-yellow); }
.score-label.poor { color: var(--error-red); }

.graded-by {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.grade-bar {
    width: 100%;
    height: 8px;
    background: #f3f4f6;
    border-radius: 4px;
    overflow: hidden;
}

.grade-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.grade-fill.excellent { background: var(--success-green); }
.grade-fill.good { background: var(--warning-yellow); }
.grade-fill.poor { background: var(--error-red); }

.feedback-section {
    background: var(--light-cream);
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.feedback-section h5 {
    margin: 0 0 0.5rem 0;
    color: var(--primary-brown);
    font-size: 1rem;
}

.feedback-text {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.5;
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
    .grade-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .grade-score {
        text-align: center;
    }
    
    .task-meta {
        justify-content: center;
    }
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <div class="page-header">
        <h1>My Grades</h1>
        <p>View your academic performance and feedback from instructors</p>
    </div>

    @if($grades->count() > 0)
        <!-- Grades List -->
        @foreach($grades as $grade)
        @php
            $scoreCategory = $grade->score >= 80 ? 'excellent' : ($grade->score >= 60 ? 'good' : 'poor');
            $scoreLabel = $grade->score >= 80 ? 'Excellent' : ($grade->score >= 60 ? 'Good' : 'Needs Improvement');
        @endphp
        <div class="grade-card">
            <div class="grade-header">
                <div class="task-info">
                    <h3>{{ $grade->task->title ?? 'Task Title' }}</h3>
                    <p class="class-name">{{ $grade->class->title ?? 'Class Name' }}</p>
                    <div class="task-meta">
                        @if($grade->gradedBy)
                        <div class="meta-item">
                            <i class="bx bx-user-check"></i>
                            <span>Graded by {{ $grade->gradedBy->name }}</span>
                        </div>
                        @endif
                        <div class="meta-item">
                            <i class="bx bx-calendar"></i>
                            <span>{{ $grade->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($grade->task && $grade->task->due_date)
                        <div class="meta-item">
                            <i class="bx bx-time"></i>
                            <span>Due: {{ $grade->task->due_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="grade-score">
                    <div class="score-number {{ $scoreCategory }}">{{ $grade->score }}/100</div>
                    <div class="score-label {{ $scoreCategory }}">{{ $scoreLabel }}</div>
                    @if($grade->gradedBy)
                    <div class="graded-by">by {{ $grade->gradedBy->name }}</div>
                    @endif
                </div>
            </div>
            
            <div class="grade-content">
                <!-- Progress Bar -->
                <div class="grade-bar">
                    <div class="grade-fill {{ $scoreCategory }}" style="width: {{ $grade->score }}%"></div>
                </div>
                
                <!-- Feedback -->
                @if($grade->feedback)
                <div class="feedback-section">
                    <h5>Instructor Feedback</h5>
                    <p class="feedback-text">{{ $grade->feedback }}</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        @if($grades->hasPages())
        <div class="pagination-wrapper">
            {{ $grades->links() }}
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="bx bx-trophy"></i>
            <h3>No Grades Yet</h3>
            <p>You don't have any grades yet. Complete some tasks in your enrolled classes to see your progress here!</p>
            <a href="{{ route('member.enrollments') }}" class="btn-browse">View My Enrollments</a>
        </div>
    @endif
</div>
@endsection