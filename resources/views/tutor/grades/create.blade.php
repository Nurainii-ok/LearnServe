@extends('layouts.tutor')

@section('title', 'Add Student Grade')

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
    min-height: 100px;
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

.score-preview {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    margin-top: 0.5rem;
}

.grade-preview {
    font-size: 1.5rem;
    font-weight: 700;
    text-align: center;
    padding: 0.5rem;
    border-radius: 8px;
    margin-top: 0.5rem;
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
            <h2>Add Student Grade</h2>
            <a href="{{ route('tutor.grades') }}" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Grades
            </a>
        </div>

        <form action="{{ route('tutor.grades.store') }}" method="POST" class="form-body">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label for="class_id">Class *</label>
                    <select id="class_id" name="class_id" class="form-control" required>
                        <option value="">Select a class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="student_id">Student *</label>
                    <select id="student_id" name="student_id" class="form-control" required>
                        <option value="">Select a student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="task_id">Task/Assignment (Optional)</label>
                    <select id="task_id" name="task_id" class="form-control">
                        <option value="">Select a task (optional)</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                                {{ $task->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('task_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Grade Type *</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="">Select type</option>
                        <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                        <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Exam</option>
                        <option value="project" {{ old('type') == 'project' ? 'selected' : '' }}>Project</option>
                        <option value="participation" {{ old('type') == 'participation' ? 'selected' : '' }}>Participation</option>
                    </select>
                    @error('type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="score">Score (0-100) *</label>
                <input type="number" id="score" name="score" class="form-control" value="{{ old('score') }}" min="0" max="100" step="0.1" required>
                @error('score')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div id="grade-preview" class="grade-preview" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea id="feedback" name="feedback" class="form-control" placeholder="Provide feedback for the student (optional)">{{ old('feedback') }}</textarea>
                @error('feedback')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('tutor.grades') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Add Grade</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus first input
    document.getElementById('class_id').focus();
    
    // Grade preview functionality
    const scoreInput = document.getElementById('score');
    const gradePreview = document.getElementById('grade-preview');
    
    function updateGradePreview() {
        const score = parseFloat(scoreInput.value);
        if (isNaN(score) || score < 0 || score > 100) {
            gradePreview.style.display = 'none';
            return;
        }
        
        let grade = 'F';
        let color = '#ef4444';
        let bgColor = 'rgba(239, 68, 68, 0.1)';
        
        if (score >= 90) {
            grade = 'A';
            color = '#10b981';
            bgColor = 'rgba(16, 185, 129, 0.1)';
        } else if (score >= 80) {
            grade = 'B';
            color = '#3b82f6';
            bgColor = 'rgba(59, 130, 246, 0.1)';
        } else if (score >= 70) {
            grade = 'C';
            color = '#ecac57';
            bgColor = 'rgba(236, 172, 87, 0.1)';
        } else if (score >= 60) {
            grade = 'D';
            color = '#f59e0b';
            bgColor = 'rgba(245, 158, 11, 0.1)';
        }
        
        gradePreview.textContent = `Grade: ${grade} (${score}%)`;
        gradePreview.style.color = color;
        gradePreview.style.backgroundColor = bgColor;
        gradePreview.style.display = 'block';
    }
    
    scoreInput.addEventListener('input', updateGradePreview);
    scoreInput.addEventListener('change', updateGradePreview);
    
    // Initial preview if score is already filled
    if (scoreInput.value) {
        updateGradePreview();
    }
});
</script>
@endsection