@extends('layouts.tutor')

@section('title', 'Edit Grade')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4" style="color: #944e25;">Edit Grade</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('tutor.dashboard') }}" style="color: #944e25;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tutor.grades') }}" style="color: #944e25;">Grades</a></li>
        <li class="breadcrumb-item active">Edit Grade</li>
    </ol>

    <div class="card mb-4" style="border-color: #ecac57;">
        <div class="card-header" style="background-color: #944e25; color: white;">
            <i class="fas fa-edit me-1"></i>
            Edit Grade for {{ $grade->student->name }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tutor.grades.update', $grade->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                            <select class="form-select" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $grade->student_id == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select" id="class_id" name="class_id" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $grade->class_id == $class->id ? 'selected' : '' }}>
                                        {{ $class->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="task_id" class="form-label">Task (Optional)</label>
                            <select class="form-select" id="task_id" name="task_id">
                                <option value="">No specific task</option>
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}" {{ $grade->task_id == $task->id ? 'selected' : '' }}>
                                        {{ $task->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Grade Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="assignment" {{ $grade->type == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                <option value="quiz" {{ $grade->type == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="exam" {{ $grade->type == 'exam' ? 'selected' : '' }}>Exam</option>
                                <option value="project" {{ $grade->type == 'project' ? 'selected' : '' }}>Project</option>
                                <option value="participation" {{ $grade->type == 'participation' ? 'selected' : '' }}>Participation</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="score" class="form-label">Score (0-100) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="score" name="score" 
                                   min="0" max="100" step="0.01" value="{{ old('score', $grade->score) }}" required>
                            <div class="form-text">Enter score between 0 and 100</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="grade" class="form-label">Letter Grade</label>
                            <input type="text" class="form-control" id="grade" name="grade" 
                                   maxlength="2" value="{{ old('grade', $grade->grade) }}" placeholder="A, B, C, D, F">
                            <div class="form-text">Optional: Will be auto-calculated if empty</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="feedback" class="form-label">Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="4" 
                              placeholder="Provide feedback for the student...">{{ old('feedback', $grade->feedback) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('tutor.grades') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Grades
                    </a>
                    <button type="submit" class="btn text-white" style="background-color: #944e25;">
                        <i class="fas fa-save me-1"></i>Update Grade
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-calculate letter grade based on score
document.getElementById('score').addEventListener('input', function() {
    const score = parseFloat(this.value);
    const gradeField = document.getElementById('grade');
    
    if (!isNaN(score)) {
        let letterGrade = '';
        if (score >= 90) letterGrade = 'A';
        else if (score >= 80) letterGrade = 'B';
        else if (score >= 70) letterGrade = 'C';
        else if (score >= 60) letterGrade = 'D';
        else letterGrade = 'F';
        
        gradeField.value = letterGrade;
    }
});
</script>
@endsection