<?php

// Test script untuk menambahkan dummy submission data
// Jalankan dengan: php test_submission_data.php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TaskSubmission;
use App\Models\Task;
use App\Models\User;

// Cari task yang ada
$task = Task::first();
if (!$task) {
    echo "No tasks found. Please create a task first.\n";
    exit;
}

// Cari member yang ada
$member = User::where('role', 'member')->first();
if (!$member) {
    echo "No members found. Please create a member first.\n";
    exit;
}

// Buat dummy submission
$submission = TaskSubmission::create([
    'task_id' => $task->id,
    'user_id' => $member->id,
    'content' => 'This is a test submission from member. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'file_path' => null, // No file for this test
    'original_filename' => null
]);

echo "✅ Test submission created successfully!\n";
echo "Task ID: {$task->id}\n";
echo "Task Title: {$task->title}\n";
echo "Member: {$member->name}\n";
echo "Submission ID: {$submission->id}\n";
echo "\nNow refresh the tutor tasks page to see the submission count!\n";
