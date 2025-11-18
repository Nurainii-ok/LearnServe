<?php

// Test script untuk query tutor tasks
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TaskSubmission;
use App\Models\Task;
use App\Models\User;

echo "🔍 Testing Tutor Query\n\n";

// Get tutor (assuming tutor ID is 1 or find first tutor)
$tutor = User::where('role', 'tutor')->first();
if (!$tutor) {
    echo "❌ No tutor found!\n";
    exit;
}

echo "👨‍🏫 Testing with Tutor: {$tutor->name} (ID: {$tutor->id})\n\n";

// Test the exact query from TutorController
$tutorId = $tutor->id;

$tasks = Task::with(['class', 'submissions' => function($query) {
        $query->with('student');
    }])
    ->where(function($query) use ($tutorId) {
        $query->where('assigned_by', $tutorId)
            ->orWhereHas('class', function($subQuery) use ($tutorId) {
                $subQuery->where('tutor_id', $tutorId);
            });
    })
    ->latest()
    ->get();

echo "📋 Tasks found: " . $tasks->count() . "\n\n";

foreach ($tasks as $task) {
    echo "Task: '{$task->title}' (ID: {$task->id})\n";
    echo "  - Assigned by: {$task->assigned_by}\n";
    echo "  - Class: " . ($task->class->title ?? 'No class') . "\n";
    echo "  - Class tutor_id: " . ($task->class->tutor_id ?? 'No tutor') . "\n";
    echo "  - Submissions count: " . $task->submissions->count() . "\n";
    
    if ($task->submissions->count() > 0) {
        foreach ($task->submissions as $submission) {
            echo "    * Submission ID: {$submission->id}\n";
            echo "      - User ID: {$submission->user_id}\n";
            echo "      - Student: " . ($submission->student->name ?? 'Unknown') . "\n";
            echo "      - Content: " . ($submission->content ? Str::limit($submission->content, 50) : 'No content') . "\n";
            echo "      - Created: {$submission->created_at}\n";
        }
    } else {
        echo "    * No submissions found\n";
    }
    echo "\n";
}

// Test recent submissions query
echo "📊 Recent Submissions Query:\n";
$recentSubmissions = TaskSubmission::with(['task.class', 'student'])
    ->whereHas('task', function($query) use ($tutorId) {
        $query->where('assigned_by', $tutorId)
            ->orWhereHas('class', function($subQuery) use ($tutorId) {
                $subQuery->where('tutor_id', $tutorId);
            });
    })
    ->latest()
    ->take(10)
    ->get();

echo "Recent submissions found: " . $recentSubmissions->count() . "\n\n";

foreach ($recentSubmissions as $submission) {
    echo "Submission: {$submission->id}\n";
    echo "  - Student: " . ($submission->student->name ?? 'Unknown') . "\n";
    echo "  - Task: " . ($submission->task->title ?? 'Unknown') . "\n";
    echo "  - Class: " . ($submission->task->class->title ?? 'Unknown') . "\n";
    echo "  - Created: {$submission->created_at}\n\n";
}

echo "✅ Query test complete!\n";
