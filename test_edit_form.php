<!DOCTYPE html>
<html>
<head>
    <title>Test Edit Form - LearnServe</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Test Edit Form (Class ID: 1)</h2>
        
        <div class="info">
            <strong>Test Information:</strong><br>
            This form will submit to: <code>PUT /admin/classes/1</code><br>
            Testing edit functionality without image upload first.
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo '<div class="success">✓ Form data received!</div>';
            echo '<h3>POST Data:</h3>';
            echo '<pre style="background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;">';
            print_r($_POST);
            echo '</pre>';
        }
        ?>

        <form method="POST" enctype="multipart/form-data" id="testForm">
            <input type="hidden" name="_token" value="test-token">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label for="title">Class Title *</label>
                <input type="text" id="title" name="title" value="Rosblox Updated" required>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required>Updated description for Rosblox class</textarea>
            </div>

            <div class="form-group">
                <label for="tutor_id">Tutor ID *</label>
                <input type="number" id="tutor_id" name="tutor_id" value="1" required min="1">
            </div>

            <div class="form-group">
                <label for="price">Price (Rp) *</label>
                <input type="number" id="price" name="price" value="200000" required min="0" step="1000">
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" value="Self Development">
            </div>

            <button type="submit">Test Update (No Image)</button>
        </form>

        <hr style="margin: 30px 0;">

        <h3>Debug Information:</h3>
        <p><strong>Route Expected:</strong> PUT /admin/classes/1</p>
        <p><strong>Controller Method:</strong> AdminController@classesUpdate</p>
        <p><strong>Required Fields:</strong> title, description, tutor_id, price, status</p>
        <p><strong>Optional Fields:</strong> category, image</p>

        <script>
        document.getElementById('testForm').addEventListener('submit', function(e) {
            console.log('Form submitting...');
            console.log('Action would be: PUT /admin/classes/1');
            
            // Show form data
            const formData = new FormData(this);
            console.log('Form data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });
        </script>
    </div>
</body>
</html>
