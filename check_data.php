<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TaskSubmission;
use App\Models\Task;

echo "All TaskSubmissions:\n";
$submissions = TaskSubmission::all();
foreach ($submissions as $sub) {
    echo "ID: {$sub->id}, Task ID: {$sub->task_id}, User ID: {$sub->user_id}\n";
}

echo "\nAll Tasks:\n";
$tasks = Task::all();
foreach ($tasks as $task) {
    echo "ID: {$task->id}, Title: {$task->title}, Assigned by: {$task->assigned_by}\n";
}

// Check relationship
echo "\nTask-Submission Relationship:\n";
foreach ($tasks as $task) {
    $submissionCount = TaskSubmission::where('task_id', $task->id)->count();
    echo "Task {$task->id} ({$task->title}): {$submissionCount} submissions\n";
}
