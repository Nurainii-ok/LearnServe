<?php
/**
 * Test script untuk debug video upload
 * Jalankan dengan: php test_video_upload.php
 */

require_once 'vendor/autoload.php';

use App\Models\VideoContent;
use App\Models\Classes;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Video Content Creation ===\n";

try {
    // Test 1: Check if Classes exist
    echo "1. Checking Classes...\n";
    $classes = Classes::where('status', 'active')->get();
    echo "   Found " . $classes->count() . " active classes\n";
    
    if ($classes->count() == 0) {
        echo "   ERROR: No active classes found!\n";
        exit(1);
    }
    
    $firstClass = $classes->first();
    echo "   Using class: " . $firstClass->title . " (ID: " . $firstClass->id . ")\n";
    
    // Test 2: Create test video content
    echo "\n2. Creating test video content...\n";
    
    $testData = [
        'title' => 'Test Video - ' . date('Y-m-d H:i:s'),
        'description' => 'This is a test video content created by test script',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'duration' => 180,
        'class_id' => $firstClass->id,
        'order' => 1,
        'status' => 'active',
        'created_by' => $firstClass->tutor_id ?? 1
    ];
    
    echo "   Data to insert:\n";
    foreach ($testData as $key => $value) {
        echo "   - $key: $value\n";
    }
    
    // Test 3: Insert data
    echo "\n3. Inserting data...\n";
    $videoContent = VideoContent::create($testData);
    
    echo "   SUCCESS! Video content created with ID: " . $videoContent->id . "\n";
    
    // Test 4: Verify data
    echo "\n4. Verifying data...\n";
    $created = VideoContent::find($videoContent->id);
    echo "   Title: " . $created->title . "\n";
    echo "   Class: " . ($created->class ? $created->class->title : 'N/A') . "\n";
    echo "   Video URL: " . $created->video_url . "\n";
    echo "   Status: " . $created->status . "\n";
    
    echo "\n=== TEST COMPLETED SUCCESSFULLY ===\n";
    
} catch (Exception $e) {
    echo "\nERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
