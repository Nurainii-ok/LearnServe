<?php

// Test script untuk memverifikasi submissions muncul real-time
// Jalankan dengan: php test_realtime_submissions.php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TaskSubmission;
use App\Models\Task;
use App\Models\User;

echo "🔍 Checking Task Submissions Data...\n\n";

// Check total submissions
$totalSubmissions = TaskSubmission::count();
echo "📊 Total Submissions: {$totalSubmissions}\n";

// Check recent submissions
$recentSubmissions = TaskSubmission::with(['task.class', 'student'])
    ->latest()
    ->take(5)
    ->get();

echo "📋 Recent Submissions:\n";
foreach ($recentSubmissions as $submission) {
    $studentName = $submission->student->name ?? 'Unknown';
    $taskTitle = $submission->task->title ?? 'Unknown Task';
    $className = $submission->task->class->title ?? 'Unknown Class';
    $submittedAt = $submission->created_at->format('Y-m-d H:i:s');
    
    echo "  - {$studentName} submitted '{$taskTitle}' for '{$className}' at {$submittedAt}\n";
}

// Check tutor-specific submissions
echo "\n🎓 Checking Tutor-specific Submissions:\n";
$tutors = User::where('role', 'tutor')->get();

foreach ($tutors as $tutor) {
    $tutorSubmissions = TaskSubmission::with(['task.class', 'student'])
        ->whereHas('task', function($query) use ($tutor) {
            $query->where('assigned_by', $tutor->id)
                ->orWhereHas('class', function($subQuery) use ($tutor) {
                    $subQuery->where('tutor_id', $tutor->id);
                });
        })
        ->count();
    
    echo "  - {$tutor->name}: {$tutorSubmissions} submissions\n";
}

echo "\n✅ Data verification complete!\n";
echo "Now refresh the dashboards to see real-time data:\n";
echo "- Tutor Dashboard: http://127.0.0.1:8000/tutor/tasks\n";
echo "- Admin Dashboard: http://127.0.0.1:8000/admin/dashboard\n";
