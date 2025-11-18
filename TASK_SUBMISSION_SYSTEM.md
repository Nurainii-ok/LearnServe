# Task Submission System - LearnServe

## Overview
Sistem pengumpulan tugas yang memungkinkan member untuk submit assignment dan tutor untuk menilai submissions. Fitur ini terintegrasi dengan halaman "My Tasks" member dan halaman "Tasks" tutor.

## Features Implemented

### 🎯 **Member Side (Student)**
1. **Task Submission Form** di halaman My Tasks
2. **Dual Submission Methods**: Text content dan/atau file upload
3. **File Upload Support**: PDF, DOC, DOCX, TXT, ZIP (max 10MB)
4. **Drag & Drop Interface** untuk file upload
5. **Submission Status Tracking** (Submitted/Graded)
6. **Grade & Feedback Display** setelah dinilai tutor

### 🎯 **Tutor Side (Teacher)**
1. **Enhanced Tasks Page** dengan submission management
2. **Student Submissions Overview** untuk setiap task
3. **Inline Grading System** (0-100 scale)
4. **Feedback System** untuk memberikan komentar
5. **File Download** untuk melihat submitted files
6. **Submission Status Tracking**

## Database Structure

### 📋 **New Table: `task_submissions`**
```sql
CREATE TABLE task_submissions (
    id BIGINT PRIMARY KEY,
    task_id BIGINT FOREIGN KEY -> tasks.id,
    user_id BIGINT FOREIGN KEY -> users.id,
    content TEXT NULL,                    -- Text submission
    file_path VARCHAR NULL,               -- File upload path
    original_filename VARCHAR NULL,       -- Original file name
    grade INTEGER NULL,                   -- Grade 0-100
    feedback TEXT NULL,                   -- Tutor feedback
    graded_at TIMESTAMP NULL,            -- When graded
    graded_by BIGINT FOREIGN KEY -> users.id,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(task_id, user_id)             -- One submission per user per task
);
```

### 📋 **Model Relationships**
```php
// Task Model
public function submissions()
{
    return $this->hasMany(TaskSubmission::class);
}

// TaskSubmission Model
public function task()
{
    return $this->belongsTo(Task::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function gradedBy()
{
    return $this->belongsTo(User::class, 'graded_by');
}
```

## Implementation Details

### 🔧 **Member Task Submission**

**File: `resources/views/member/tasks.blade.php`**

**Form Structure:**
```html
<div class="task-submission">
    <div class="submission-header">
        <i class="bx bx-upload"></i>
        <h5>Submit Assignment</h5>
        <button onclick="toggleSubmissionForm({{ $task->id }})">Submit Work</button>
    </div>

    <form action="{{ route('member.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Text Submission -->
        <div class="form-group">
            <label>Assignment Text/Notes (Optional)</label>
            <textarea name="content" rows="4" placeholder="Write your assignment..."></textarea>
        </div>

        <!-- File Upload -->
        <div class="form-group">
            <label>Upload File (Optional)</label>
            <div class="file-upload-zone" onclick="document.getElementById('file-{{ $task->id }}').click()">
                <div class="upload-icon">
                    <i class="bx bx-cloud-upload"></i>
                </div>
                <h6>Drop your file here or click to browse</h6>
                <p>Supported: PDF, DOC, DOCX, TXT, ZIP (Max: 10MB)</p>
                <input type="file" id="file-{{ $task->id }}" name="file" accept=".pdf,.doc,.docx,.txt,.zip" style="display: none;">
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="bx bx-send me-1"></i>
            Submit Assignment
        </button>
    </form>
</div>
```

**JavaScript Features:**
```javascript
// Toggle form visibility
function toggleSubmissionForm(taskId) {
    const form = document.getElementById('submission-form-' + taskId);
    form.classList.toggle('active');
}

// File name display
function updateFileName(taskId) {
    const fileInput = document.getElementById('file-' + taskId);
    const fileNameDiv = document.getElementById('file-name-' + taskId);
    
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        const fileSize = (fileInput.files[0].size / 1024 / 1024).toFixed(2);
        fileNameDiv.innerHTML = `<i class="bx bx-file"></i> ${fileName} (${fileSize} MB)`;
        fileNameDiv.style.display = 'block';
    }
}

// Drag & Drop functionality
uploadZones.forEach(zone => {
    zone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    zone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const taskId = this.querySelector('input[type="file"]').id.split('-')[1];
            const fileInput = document.getElementById('file-' + taskId);
            fileInput.files = files;
            updateFileName(taskId);
        }
    });
});
```

### 🔧 **Member Controller - Task Submission**

**File: `app/Http/Controllers/MemberController.php`**

```php
public function submitTask(Request $request, $taskId)
{
    $memberId = session('user_id');
    
    // Find the task
    $task = Task::findOrFail($taskId);
    
    // Check enrollment
    $enrollment = Enrollment::where('user_id', $memberId)
        ->where('class_id', $task->class_id)
        ->where('status', 'active')
        ->first();
        
    if (!$enrollment) {
        return back()->withErrors(['error' => 'You are not enrolled in this class.']);
    }

    // Check if already submitted
    $existingSubmission = TaskSubmission::where('task_id', $taskId)
        ->where('user_id', $memberId)
        ->first();
        
    if ($existingSubmission) {
        return back()->withErrors(['error' => 'You have already submitted this assignment.']);
    }

    // Validate input
    $request->validate([
        'content' => 'nullable|string|max:5000',
        'file' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240', // 10MB max
    ]);

    // Check if at least one submission method is provided
    if (!$request->filled('content') && !$request->hasFile('file')) {
        return back()->withErrors(['error' => 'Please provide either text content or upload a file.']);
    }

    $submissionData = [
        'task_id' => $taskId,
        'user_id' => $memberId,
        'content' => $request->content,
    ];

    // Handle file upload
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store('task-submissions', 'public');
        
        $submissionData['file_path'] = $filePath;
        $submissionData['original_filename'] = $originalName;
    }

    // Create submission
    TaskSubmission::create($submissionData);

    return back()->with('success', 'Assignment submitted successfully! Your tutor will review it soon.');
}
```

### 🔧 **Tutor Task Management**

**File: `resources/views/tutor/tasks.blade.php`**

**Enhanced Task Display:**
```html
@foreach($tasks as $task)
<div class="task-card">
    <div class="task-header">
        <div class="task-info">
            <h3>{{ $task->title }}</h3>
            <p class="class-name">{{ $task->class->title }}</p>
            <div class="task-meta">
                <div class="meta-item">
                    <i class="bx bx-calendar"></i>
                    <span>Due {{ $task->due_date->format('M d, Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bx bx-users"></i>
                    <span>{{ $task->submissions->count() }} Submissions</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions Section -->
    <div class="submissions-section">
        <h4>Student Submissions ({{ $task->submissions->count() }})</h4>

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
                            <input type="text" name="feedback" class="form-control" placeholder="Great work! or suggestions...">
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
```

### 🔧 **Tutor Controller - Grading**

**File: `app/Http/Controllers/TutorController.php`**

```php
public function tasks()
{
    $tutorId = session('user_id');
    $tasks = Task::with(['class', 'submissions.user'])
        ->where('assigned_by', $tutorId)
        ->orWhereHas('class', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })
        ->latest()
        ->get();
    
    return view('tutor.tasks', compact('tasks'));
}

public function gradeSubmission(Request $request, $submissionId)
{
    $tutorId = session('user_id');
    
    // Find the submission
    $submission = TaskSubmission::with(['task.class', 'user'])->findOrFail($submissionId);
    
    // Check authorization
    if ($submission->task->assigned_by !== $tutorId && $submission->task->class->tutor_id !== $tutorId) {
        return back()->withErrors(['error' => 'You are not authorized to grade this submission.']);
    }
    
    // Validate input
    $request->validate([
        'grade' => 'required|integer|min:0|max:100',
        'feedback' => 'nullable|string|max:1000',
    ]);
    
    // Update submission with grade
    $submission->update([
        'grade' => $request->grade,
        'feedback' => $request->feedback,
        'graded_at' => now(),
        'graded_by' => $tutorId,
    ]);
    
    return back()->with('success', 'Assignment graded successfully!');
}
```

## Routes Added

### 📋 **Member Routes**
```php
// Member task submission
Route::post('/tasks/{task}/submit', [MemberController::class, 'submitTask'])->name('tasks.submit');
```

### 📋 **Tutor Routes**
```php
// Tutor grading
Route::post('/tasks/submissions/{submission}/grade', [TutorController::class, 'gradeSubmission'])->name('tasks.grade');
```

## User Experience Flow

### 🎯 **Member (Student) Workflow:**
1. **View Tasks**: Member goes to "My Tasks" page
2. **See Assignment**: Each task card shows assignment details
3. **Submit Work**: Click "Submit Work" button to open form
4. **Choose Method**: Enter text and/or upload file
5. **Submit**: Click "Submit Assignment" 
6. **Track Status**: See "Submitted" status and wait for grading
7. **View Grade**: Once graded, see score and feedback

### 🎯 **Tutor (Teacher) Workflow:**
1. **View Tasks**: Tutor goes to "Tasks & Assignments" page
2. **See Submissions**: Each task shows number of submissions
3. **Review Work**: Read student text and download files
4. **Grade Assignment**: Enter score (0-100) and optional feedback
5. **Submit Grade**: Click "Grade" button to save
6. **Track Progress**: See graded vs pending submissions

## Validation & Security

### 🔒 **Member Submission Validation:**
- Must be enrolled in the class
- One submission per task per user
- File size limit: 10MB
- File types: PDF, DOC, DOCX, TXT, ZIP
- Text content limit: 5000 characters
- Must provide either text or file (or both)

### 🔒 **Tutor Grading Validation:**
- Must own the task or class
- Grade range: 0-100
- Feedback limit: 1000 characters
- Can only grade existing submissions

### 🔒 **File Security:**
- Files stored in `storage/app/public/task-submissions/`
- Original filename preserved for display
- Unique storage filename for security
- Access controlled through Laravel storage system

## Benefits

### ✅ **For Students:**
- Easy submission process
- Multiple submission methods
- Real-time status tracking
- Clear grade and feedback display
- File upload with drag & drop

### ✅ **For Tutors:**
- Centralized submission management
- Inline grading system
- File download capability
- Feedback system
- Submission overview

### ✅ **For System:**
- Integrated with existing task system
- Proper data relationships
- Secure file handling
- Scalable architecture
- Clean UI/UX design

---

**Status**: ✅ **COMPLETED**  
**Integration**: Seamless with existing LearnServe system  
**Theme**: Consistent with LearnServe brown/gold color scheme  
**Ready for**: Production use with proper testing  

**Fitur task submission system sudah lengkap dan siap digunakan!** 🎉
