<?php

// Debug script untuk memeriksa submissions data
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TaskSubmission;
use App\Models\Task;
use App\Models\User;
use App\Models\Classes;

echo "🔍 DEBUG: Task Submissions Analysis\n\n";

// 1. Check all submissions
$allSubmissions = TaskSubmission::with(['task', 'student'])->get();
echo "📊 Total Submissions in Database: " . $allSubmissions->count() . "\n\n";

foreach ($allSubmissions as $submission) {
    echo "Submission ID: {$submission->id}\n";
    echo "  - Task ID: {$submission->task_id}\n";
    echo "  - User ID: {$submission->user_id}\n";
    echo "  - Student: " . ($submission->student->name ?? 'Unknown') . "\n";
    echo "  - Task: " . ($submission->task->title ?? 'Unknown') . "\n";
    echo "  - Content: " . ($submission->content ?? 'No content') . "\n";
    echo "  - Created: {$submission->created_at}\n\n";
}

// 2. Check tasks with submissions
echo "📋 Tasks Analysis:\n";
$tasks = Task::with(['submissions', 'class'])->get();

foreach ($tasks as $task) {
    echo "Task ID: {$task->id} - '{$task->title}'\n";
    echo "  - Class: " . ($task->class->title ?? 'No class') . "\n";
    echo "  - Assigned by: {$task->assigned_by}\n";
    echo "  - Submissions count: " . $task->submissions->count() . "\n";
    
    if ($task->submissions->count() > 0) {
        foreach ($task->submissions as $sub) {
            echo "    * Submission by User ID: {$sub->user_id} - " . ($sub->student->name ?? 'Unknown') . "\n";
        }
    }
    echo "\n";
}

// 3. Check tutor relationship
echo "🎓 Tutor Analysis:\n";
$tutors = User::where('role', 'tutor')->get();

foreach ($tutors as $tutor) {
    echo "Tutor: {$tutor->name} (ID: {$tutor->id})\n";
    
    // Tasks assigned by this tutor
    $assignedTasks = Task::where('assigned_by', $tutor->id)->with('submissions')->get();
    echo "  - Tasks assigned by tutor: " . $assignedTasks->count() . "\n";
    
    // Tasks from classes owned by this tutor
    $classTasks = Task::whereHas('class', function($query) use ($tutor) {
        $query->where('tutor_id', $tutor->id);
    })->with('submissions')->get();
    echo "  - Tasks from tutor's classes: " . $classTasks->count() . "\n";
    
    // Total submissions for this tutor
    $totalSubmissions = TaskSubmission::whereHas('task', function($query) use ($tutor) {
        $query->where('assigned_by', $tutor->id)
            ->orWhereHas('class', function($subQuery) use ($tutor) {
                $subQuery->where('tutor_id', $tutor->id);
            });
    })->count();
    echo "  - Total submissions for tutor: {$totalSubmissions}\n\n";
}

// 4. Check specific task from screenshot
echo "🎯 Specific Task Analysis (testing task):\n";
$testingTask = Task::where('title', 'testing')->with(['submissions.student', 'class'])->first();

if ($testingTask) {
    echo "Task 'testing' found:\n";
    echo "  - ID: {$testingTask->id}\n";
    echo "  - Assigned by: {$testingTask->assigned_by}\n";
    echo "  - Class: " . ($testingTask->class->title ?? 'No class') . "\n";
    echo "  - Class tutor_id: " . ($testingTask->class->tutor_id ?? 'No tutor') . "\n";
    echo "  - Submissions: " . $testingTask->submissions->count() . "\n";
    
    foreach ($testingTask->submissions as $sub) {
        echo "    * User ID: {$sub->user_id}, Student: " . ($sub->student->name ?? 'Unknown') . "\n";
    }
} else {
    echo "Task 'testing' not found!\n";
}

echo "\n✅ Debug analysis complete!\n";
