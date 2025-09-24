<!DOCTYPE html>
<html>
<head>
    <title>Complete Form Test - LearnServe</title>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        textarea { height: 80px; resize: vertical; }
        button { background: #944e25; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #6b3419; }
        .error { color: #e74c3c; font-size: 12px; margin-top: 5px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .info { background: #e7f3ff; color: #0c5460; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .file-info { background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Complete Class Update Form Test</h2>
        
        <div class="info">
            <strong>Test Information:</strong><br>
            - Server: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?><br>
            - PHP Version: <?php echo PHP_VERSION; ?><br>
            - Upload Max: <?php echo ini_get('upload_max_filesize'); ?><br>
            - Post Max: <?php echo ini_get('post_max_size'); ?><br>
            - Memory Limit: <?php echo ini_get('memory_limit'); ?><br>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo '<div class="success">✓ Form submitted successfully!</div>';
            echo '<h3>Received Data:</h3>';
            echo '<pre style="background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;">';
            echo 'POST Data: ' . print_r($_POST, true);
            if (!empty($_FILES)) {
                echo 'FILES Data: ' . print_r($_FILES, true);
            }
            echo '</pre>';
            
            // Test file upload if present
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/public/storage/class_images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $filename = 'test_' . time() . '_' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    echo '<div class="success">✓ File uploaded successfully: ' . $filename . '</div>';
                } else {
                    echo '<div class="error">✗ Failed to move uploaded file</div>';
                }
            }
        }
        ?>

        <form method="POST" enctype="multipart/form-data" id="testForm">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label for="title">Class Title *</label>
                <input type="text" id="title" name="title" value="<?php echo $_POST['title'] ?? 'Test Class Update'; ?>" required>
                <div id="title-error" class="error" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required><?php echo $_POST['description'] ?? 'This is a test description for class update functionality.'; ?></textarea>
                <div id="description-error" class="error" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="tutor_id">Tutor ID *</label>
                <input type="number" id="tutor_id" name="tutor_id" value="<?php echo $_POST['tutor_id'] ?? '1'; ?>" required min="1">
                <div id="tutor-error" class="error" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="price">Price (Rp) *</label>
                <input type="number" id="price" name="price" value="<?php echo $_POST['price'] ?? '150000'; ?>" required min="0" step="1000">
                <div id="price-error" class="error" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active" <?php echo ($_POST['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($_POST['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    <option value="completed" <?php echo ($_POST['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
                <div id="status-error" class="error" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" value="<?php echo $_POST['category'] ?? 'Web Development'; ?>" maxlength="255">
                <div id="category-error" class="error" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="image">Class Image</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <div class="file-info">
                    Supported formats: JPEG, PNG, JPG, GIF, WebP<br>
                    Maximum size: 10MB
                </div>
                <div id="file-size-error" class="error" style="display: none;">File size must be less than 10MB</div>
                <div id="file-type-error" class="error" style="display: none;">Please select a valid image file</div>
            </div>

            <button type="submit" id="submitBtn">Test Update Class</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('testForm');
        const imageInput = document.getElementById('image');
        const submitBtn = document.getElementById('submitBtn');
        const fileSizeError = document.getElementById('file-size-error');
        const fileTypeError = document.getElementById('file-type-error');

        // File validation
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            
            // Reset errors
            fileSizeError.style.display = 'none';
            fileTypeError.style.display = 'none';
            
            if (file) {
                console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
                
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    fileTypeError.style.display = 'block';
                    this.value = '';
                    return;
                }
                
                // Check file size (10MB)
                const maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    fileSizeError.style.display = 'block';
                    this.value = '';
                    return;
                }
                
                console.log('File validation passed');
            }
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            
            // Basic validation
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const tutorId = document.getElementById('tutor_id').value;
            const price = document.getElementById('price').value;
            const status = document.getElementById('status').value;
            
            let hasError = false;
            
            // Reset errors
            document.querySelectorAll('.error').forEach(el => el.style.display = 'none');
            
            if (!title) {
                document.getElementById('title-error').textContent = 'Title is required';
                document.getElementById('title-error').style.display = 'block';
                hasError = true;
            }
            
            if (!description) {
                document.getElementById('description-error').textContent = 'Description is required';
                document.getElementById('description-error').style.display = 'block';
                hasError = true;
            }
            
            if (!tutorId || tutorId < 1) {
                document.getElementById('tutor-error').textContent = 'Valid tutor ID is required';
                document.getElementById('tutor-error').style.display = 'block';
                hasError = true;
            }
            
            if (!price || price < 0) {
                document.getElementById('price-error').textContent = 'Valid price is required';
                document.getElementById('price-error').style.display = 'block';
                hasError = true;
            }
            
            if (!status) {
                document.getElementById('status-error').textContent = 'Status is required';
                document.getElementById('status-error').style.display = 'block';
                hasError = true;
            }
            
            if (hasError) {
                e.preventDefault();
                console.log('Form validation failed');
                return false;
            }
            
            console.log('Form validation passed, submitting...');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
        });
    });
    </script>
</body>
</html>
