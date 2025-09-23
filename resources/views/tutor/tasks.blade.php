@extends('layouts.tutor')

@section('title', 'Tasks & Assignments')

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
    --info-blue: #3b82f6;
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
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.btn-primary {
    background: var(--primary-brown);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.task-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.task-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
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

.submissions-section {
    padding: 1.5rem;
}

.submissions-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 1rem;
}

.submissions-header h4 {
    margin: 0;
    color: var(--primary-brown);
    font-size: 1.1rem;
}

.submission-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.submission-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.student-name {
    font-weight: 600;
    color: var(--text-primary);
}

.submission-date {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.submission-status {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-submitted {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-yellow);
}

.status-graded {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-green);
}

.submission-content {
    margin-bottom: 1rem;
}

.submission-text {
    background: white;
    padding: 0.75rem;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    margin-bottom: 0.75rem;
}

.file-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-brown);
    text-decoration: none;
    font-size: 0.875rem;
}

.file-link:hover {
    color: var(--deep-brown);
    text-decoration: none;
}

.grading-section {
    border-top: 1px solid #e5e7eb;
    padding-top: 1rem;
    margin-top: 1rem;
}

.grade-form {
    display: flex;
    gap: 1rem;
    align-items: end;
}

.form-group {
    flex: 1;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(148, 78, 37, 0.1);
}

.btn-grade {
    background: var(--success-green);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-grade:hover {
    background: #059669;
    transform: translateY(-1px);
}

.grade-display {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.grade-score {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--success-green);
}

.grade-feedback {
    background: rgba(16, 185, 129, 0.05);
    border: 1px solid rgba(16, 185, 129, 0.2);
    padding: 0.75rem;
    border-radius: 6px;
    margin-top: 0.5rem;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Tasks & Assignments</h1>
        <a href="#" class="btn-primary">
            <i class="bx bx-plus me-1"></i>
            Create New Task
        </a>
    </div>

    @if(isset($tasks) && $tasks->count() > 0)
        <!-- Tasks with Submissions -->
        @foreach($tasks as $task)
        <div class="task-card">
            <div class="task-header">
                <div class="task-info">
                    <h3>{{ $task->title }}</h3>
                    <p class="class-name">{{ $task->class->title ?? 'Class Name' }}</p>
                    <div class="task-meta">
                        <div class="meta-item">
                            <i class="bx bx-calendar"></i>
                            <span>Due {{ $task->due_date->format('M d, Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="bx bx-users"></i>
                            <span>{{ $task->submissions->count() }} Submissions</span>
                        </div>
                        @if($task->priority)
                        <div class="meta-item">
                            <i class="bx bx-flag"></i>
                            <span>{{ ucfirst($task->priority) }} Priority</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submissions Section -->
            <div class="submissions-section">
                <div class="submissions-header">
                    <h4>
                        <i class="bx bx-file-blank me-1"></i>
                        Student Submissions ({{ $task->submissions->count() }})
                    </h4>
                </div>

                @forelse($task->submissions as $submission)
                <div class="submission-item">
                    <div class="submission-header">
                        <div class="student-info">
                            <i class="bx bx-user-circle"></i>
                            <span class="student-name">{{ $submission->user->name }}</span>
                            <span class="submission-date">
                                Submitted {{ $submission->created_at->format('M d, Y H:i') }}
                            </span>
                        </div>
                        <span class="submission-status {{ $submission->grade ? 'status-graded' : 'status-submitted' }}">
                            {{ $submission->grade ? 'Graded' : 'Pending Review' }}
                        </span>
                    </div>

                    <div class="submission-content">
                        @if($submission->content)
                        <div class="submission-text">
                            <strong>Student Answer:</strong><br>
                            {{ $submission->content }}
                        </div>
                        @endif

                        @if($submission->file_path)
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="file-link">
                            <i class="bx bx-download"></i>
                            {{ $submission->original_filename }}
                        </a>
                        @endif
                    </div>

                    @if($submission->grade)
                        <!-- Show existing grade -->
                        <div class="grade-display">
                            <span class="grade-score">{{ $submission->grade }}/100</span>
                            <span class="text-muted">
                                Graded on {{ $submission->graded_at->format('M d, Y') }}
                            </span>
                        </div>
                        @if($submission->feedback)
                        <div class="grade-feedback">
                            <strong>Feedback:</strong> {{ $submission->feedback }}
                        </div>
                        @endif
                    @else
                        <!-- Grading Form -->
                        <div class="grading-section">
                            <form action="{{ route('tutor.tasks.grade', $submission->id) }}" method="POST" class="grade-form">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Grade (0-100)</label>
                                    <input type="number" name="grade" class="form-control" min="0" max="100" required>
                                </div>
                                <div class="form-group" style="flex: 2;">
                                    <label class="form-label">Feedback (Optional)</label>
                                    <input type="text" name="feedback" class="form-control" placeholder="Great work! or suggestions for improvement...">
                                </div>
                                <button type="submit" class="btn-grade">
                                    <i class="bx bx-check me-1"></i>
                                    Grade
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                @empty
                <div class="empty-state">
                    <i class="bx bx-inbox"></i>
                    <h4>No Submissions Yet</h4>
                    <p>Students haven't submitted their work for this assignment yet.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    @else
        <!-- Empty State -->
        <div class="task-card">
            <div class="empty-state">
                <i class="bx bx-task"></i>
                <h3>No Tasks Created Yet</h3>
                <p>Create your first assignment to start receiving student submissions.</p>
                <a href="#" class="btn-primary mt-3">
                    <i class="bx bx-plus me-1"></i>
                    Create First Task
                </a>
            </div>
        </div>
    @endif
</div>
@endsection