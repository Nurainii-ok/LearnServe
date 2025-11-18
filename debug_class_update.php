<?php
// Debug script untuk class update issue
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test database connection
try {
    $pdo = DB::connection()->getPdo();
    echo "✓ Database connection successful<br>";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test Classes model
try {
    $class = App\Models\Classes::find(1); // Assuming ID 1 exists
    if ($class) {
        echo "✓ Classes model working, found class: " . $class->title . "<br>";
        
        // Test update without file
        $originalTitle = $class->title;
        $testTitle = $originalTitle . " (test)";
        
        $class->update(['title' => $testTitle]);
        echo "✓ Test update successful<br>";
        
        // Revert
        $class->update(['title' => $originalTitle]);
        echo "✓ Reverted successfully<br>";
        
    } else {
        echo "✗ No class found with ID 1<br>";
    }
} catch (Exception $e) {
    echo "✗ Classes model error: " . $e->getMessage() . "<br>";
}

// Test file upload directory
$uploadDir = __DIR__ . '/public/storage/class_images';
echo "<br><strong>Upload Directory Check:</strong><br>";
echo "Path: " . $uploadDir . "<br>";
echo "Exists: " . (is_dir($uploadDir) ? 'Yes' : 'No') . "<br>";
echo "Writable: " . (is_writable($uploadDir) ? 'Yes' : 'No') . "<br>";

if (is_dir($uploadDir)) {
    $perms = fileperms($uploadDir);
    echo "Permissions: " . substr(sprintf('%o', $perms), -4) . "<br>";
}

// Test form validation
echo "<br><strong>Form Validation Test:</strong><br>";
$validator = Validator::make([
    'title' => 'Test Class',
    'description' => 'Test Description',
    'tutor_id' => 1,
    'price' => 100000,
    'status' => 'active',
    'category' => 'Test Category'
], [
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'tutor_id' => 'required|exists:users,id',
    'price' => 'required|numeric|min:0',
    'status' => 'required|in:active,inactive,completed',
    'category' => 'nullable|string',
]);

if ($validator->passes()) {
    echo "✓ Validation rules working<br>";
} else {
    echo "✗ Validation failed:<br>";
    foreach ($validator->errors()->all() as $error) {
        echo "- " . $error . "<br>";
    }
}

// Test users table for tutors
try {
    $tutors = App\Models\User::where('role', 'tutor')->count();
    echo "✓ Found " . $tutors . " tutors in database<br>";
} catch (Exception $e) {
    echo "✗ Error checking tutors: " . $e->getMessage() . "<br>";
}
?>
