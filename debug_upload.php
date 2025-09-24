<?php
// Debug script untuk upload issue
echo "<h2>Upload Debug Information</h2>";

// Check PHP settings
echo "<h3>PHP Upload Settings:</h3>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";
echo "file_uploads: " . (ini_get('file_uploads') ? 'Enabled' : 'Disabled') . "<br>";

// Check directory permissions
echo "<h3>Directory Permissions:</h3>";
$uploadDir = __DIR__ . '/public/storage/class_images';
echo "Upload directory: " . $uploadDir . "<br>";
echo "Directory exists: " . (is_dir($uploadDir) ? 'Yes' : 'No') . "<br>";
echo "Directory writable: " . (is_writable($uploadDir) ? 'Yes' : 'No') . "<br>";

if (is_dir($uploadDir)) {
    $perms = fileperms($uploadDir);
    echo "Directory permissions: " . substr(sprintf('%o', $perms), -4) . "<br>";
}

// Check Laravel storage link
echo "<h3>Laravel Storage:</h3>";
$storageLink = __DIR__ . '/public/storage';
echo "Storage link exists: " . (is_link($storageLink) ? 'Yes' : 'No') . "<br>";
echo "Storage link target: " . (is_link($storageLink) ? readlink($storageLink) : 'Not a symlink') . "<br>";

// Check .htaccess
echo "<h3>Server Configuration:</h3>";
$htaccess = __DIR__ . '/.htaccess';
echo ".htaccess exists: " . (file_exists($htaccess) ? 'Yes' : 'No') . "<br>";

if (file_exists($htaccess)) {
    $content = file_get_contents($htaccess);
    if (strpos($content, 'post_max_size') !== false) {
        echo ".htaccess has upload settings: Yes<br>";
    } else {
        echo ".htaccess has upload settings: No<br>";
    }
}

// Test file upload simulation
echo "<h3>Upload Test Form:</h3>";
?>
<form action="test_upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="test_image" accept="image/*">
    <button type="submit">Test Upload</button>
</form>

<?php
// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_image'])) {
    echo "<h3>Upload Test Results:</h3>";
    
    $file = $_FILES['test_image'];
    echo "File name: " . $file['name'] . "<br>";
    echo "File size: " . $file['size'] . " bytes (" . round($file['size']/1024/1024, 2) . " MB)<br>";
    echo "File type: " . $file['type'] . "<br>";
    echo "Upload error: " . $file['error'] . "<br>";
    
    // Error codes explanation
    $errors = [
        UPLOAD_ERR_OK => 'No error',
        UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
        UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL => 'File partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'No temporary directory',
        UPLOAD_ERR_CANT_WRITE => 'Cannot write to disk',
        UPLOAD_ERR_EXTENSION => 'Upload stopped by extension'
    ];
    
    echo "Error description: " . ($errors[$file['error']] ?? 'Unknown error') . "<br>";
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $targetDir = __DIR__ . '/public/storage/class_images/';
        $targetFile = $targetDir . 'test_' . time() . '_' . basename($file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            echo "<span style='color: green;'>✓ File uploaded successfully to: " . $targetFile . "</span><br>";
        } else {
            echo "<span style='color: red;'>✗ Failed to move uploaded file</span><br>";
        }
    }
}
?>
