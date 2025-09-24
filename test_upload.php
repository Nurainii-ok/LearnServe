<?php
// Simple upload test script
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_image'])) {
    echo "<h2>Upload Test Results</h2>";
    
    $file = $_FILES['test_image'];
    echo "<strong>File Information:</strong><br>";
    echo "Name: " . $file['name'] . "<br>";
    echo "Size: " . $file['size'] . " bytes (" . round($file['size']/1024/1024, 2) . " MB)<br>";
    echo "Type: " . $file['type'] . "<br>";
    echo "Tmp Name: " . $file['tmp_name'] . "<br>";
    echo "Error: " . $file['error'] . "<br>";
    
    // Error codes
    $errors = [
        UPLOAD_ERR_OK => 'No error',
        UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive',
        UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive',
        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
    ];
    
    echo "Error Description: " . ($errors[$file['error']] ?? 'Unknown error') . "<br><br>";
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Test directory creation and permissions
        $uploadDir = __DIR__ . '/public/storage/class_images/';
        
        if (!is_dir($uploadDir)) {
            echo "Creating upload directory...<br>";
            if (mkdir($uploadDir, 0755, true)) {
                echo "✓ Directory created successfully<br>";
            } else {
                echo "✗ Failed to create directory<br>";
            }
        } else {
            echo "✓ Upload directory exists<br>";
        }
        
        if (is_writable($uploadDir)) {
            echo "✓ Directory is writable<br>";
        } else {
            echo "✗ Directory is not writable<br>";
        }
        
        // Try to move file
        $filename = 'test_' . time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $filename;
        
        echo "Target path: " . $targetPath . "<br>";
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            echo "<span style='color: green; font-weight: bold;'>✓ SUCCESS: File uploaded successfully!</span><br>";
            echo "File saved as: " . $filename . "<br>";
            
            // Show image if it's an image
            if (getimagesize($targetPath)) {
                echo "<br><img src='public/storage/class_images/" . $filename . "' style='max-width: 200px; max-height: 200px; border: 1px solid #ccc;'><br>";
            }
        } else {
            echo "<span style='color: red; font-weight: bold;'>✗ FAILED: Could not move uploaded file</span><br>";
            echo "Check directory permissions and disk space<br>";
        }
    } else {
        echo "<span style='color: red; font-weight: bold;'>Upload failed with error code: " . $file['error'] . "</span><br>";
    }
    
    echo "<br><a href='test_upload.php'>← Back to test form</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin-bottom: 20px; }
        input[type="file"] { padding: 10px; border: 1px solid #ddd; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background: #005a87; }
    </style>
</head>
<body>
    <h2>File Upload Test</h2>
    <p>This will test if file uploads are working on your server.</p>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Select an image file:</label><br>
            <input type="file" name="test_image" accept="image/*" required>
        </div>
        <button type="submit">Test Upload</button>
    </form>
    
    <hr>
    <h3>Server Configuration:</h3>
    <?php
    echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
    echo "post_max_size: " . ini_get('post_max_size') . "<br>";
    echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";
    echo "memory_limit: " . ini_get('memory_limit') . "<br>";
    echo "file_uploads: " . (ini_get('file_uploads') ? 'Enabled' : 'Disabled') . "<br>";
    ?>
</body>
</html>
