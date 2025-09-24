<?php
// Test class update functionality directly
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate a request
$request = Illuminate\Http\Request::create('/admin/classes/1', 'PUT', [
    'title' => 'Test Class Update',
    'description' => 'Test description for class update',
    'tutor_id' => 1,
    'price' => 150000,
    'status' => 'active',
    'category' => 'Test Category',
    '_token' => 'test-token',
    '_method' => 'PUT'
]);

// Add CSRF token to session
$session = new Illuminate\Session\Store(
    'laravel_session',
    new Illuminate\Session\ArraySessionHandler(60)
);
$session->put('_token', 'test-token');
$request->setLaravelSession($session);

try {
    echo "Testing class update without file upload...\n";
    
    // Get the controller
    $controller = new App\Http\Controllers\AdminController();
    
    // Test the update method
    $response = $controller->classesUpdate($request, 1);
    
    echo "Response type: " . get_class($response) . "\n";
    
    if ($response instanceof Illuminate\Http\RedirectResponse) {
        echo "Redirect URL: " . $response->getTargetUrl() . "\n";
        
        $session = $response->getSession();
        if ($session && $session->has('success')) {
            echo "Success message: " . $session->get('success') . "\n";
        }
        
        if ($session && $session->has('errors')) {
            echo "Errors: " . print_r($session->get('errors'), true) . "\n";
        }
    }
    
    echo "✓ Test completed successfully\n";
    
} catch (Exception $e) {
    echo "✗ Error occurred:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}

// Test with file upload simulation
echo "\n" . str_repeat("-", 50) . "\n";
echo "Testing with file upload simulation...\n";

// Create a temporary test image
$testImagePath = sys_get_temp_dir() . '/test_image.jpg';
$imageData = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A');
file_put_contents($testImagePath, $imageData);

// Create uploaded file instance
$uploadedFile = new Illuminate\Http\UploadedFile(
    $testImagePath,
    'test_image.jpg',
    'image/jpeg',
    null,
    true
);

$requestWithFile = Illuminate\Http\Request::create('/admin/classes/1', 'PUT', [
    'title' => 'Test Class Update With Image',
    'description' => 'Test description with image upload',
    'tutor_id' => 1,
    'price' => 200000,
    'status' => 'active',
    'category' => 'Test Category',
    '_token' => 'test-token',
    '_method' => 'PUT'
], [], [
    'image' => $uploadedFile
]);

$requestWithFile->setLaravelSession($session);

try {
    $response = $controller->classesUpdate($requestWithFile, 1);
    
    echo "Response type: " . get_class($response) . "\n";
    
    if ($response instanceof Illuminate\Http\RedirectResponse) {
        echo "Redirect URL: " . $response->getTargetUrl() . "\n";
        
        $session = $response->getSession();
        if ($session && $session->has('success')) {
            echo "Success message: " . $session->get('success') . "\n";
        }
        
        if ($session && $session->has('errors')) {
            echo "Errors: " . print_r($session->get('errors'), true) . "\n";
        }
    }
    
    echo "✓ File upload test completed\n";
    
} catch (Exception $e) {
    echo "✗ File upload error:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

// Cleanup
if (file_exists($testImagePath)) {
    unlink($testImagePath);
}

echo "\nTest completed.\n";
?>
