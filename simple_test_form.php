<!DOCTYPE html>
<html>
<head>
    <title>Simple Test Form</title>
    <meta name="csrf-token" content="test-token">
</head>
<body>
    <h2>Simple Class Update Test</h2>
    
    <?php if (isset($_POST['title'])): ?>
        <div style="background: #d4edda; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;">
            <h3>Form Data Received:</h3>
            <pre><?php print_r($_POST); ?></pre>
            
            <?php if (isset($_FILES['image'])): ?>
                <h3>File Data:</h3>
                <pre><?php print_r($_FILES['image']); ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" style="max-width: 600px;">
        <input type="hidden" name="_token" value="test-token">
        <input type="hidden" name="_method" value="PUT">
        
        <div style="margin-bottom: 15px;">
            <label>Title:</label><br>
            <input type="text" name="title" value="Test Class" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Description:</label><br>
            <textarea name="description" required style="width: 100%; padding: 8px; height: 80px;">Test Description</textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Tutor ID:</label><br>
            <input type="number" name="tutor_id" value="1" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Price:</label><br>
            <input type="number" name="price" value="100000" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Status:</label><br>
            <select name="status" required style="width: 100%; padding: 8px;">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Category:</label><br>
            <input type="text" name="category" value="Test Category" style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Image:</label><br>
            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 8px;">
        </div>
        
        <button type="submit" style="background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Test Submit
        </button>
    </form>
    
    <hr>
    <h3>Server Info:</h3>
    <p>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></p>
    <p>post_max_size: <?php echo ini_get('post_max_size'); ?></p>
    <p>max_execution_time: <?php echo ini_get('max_execution_time'); ?></p>
    <p>memory_limit: <?php echo ini_get('memory_limit'); ?></p>
    
    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Form submitting...');
        
        const formData = new FormData(this);
        console.log('Form data:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });
    </script>
</body>
</html>
