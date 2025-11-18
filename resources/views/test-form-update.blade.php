<!DOCTYPE html>
<html>
<head>
    <title>Test Form Update - Class {{ $id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea, select { width: 300px; padding: 8px; border: 1px solid #ddd; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .result { margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Test Form Update - Class {{ $id }}</h2>
    <p><em>This form bypasses CSRF and middleware for testing purposes</em></p>
    
    <form action="/test-form-update/{{ $id }}" method="POST" enctype="multipart/form-data" id="testForm">
        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" value="Test Update {{ date('H:i:s') }}" required>
        </div>
        
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" required>Test description updated at {{ date('Y-m-d H:i:s') }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Tutor ID:</label>
            <input type="number" name="tutor_id" value="1" required>
        </div>
        
        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" value="200000" required>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Category:</label>
            <input type="text" name="category" value="Test Category">
        </div>
        
        <div class="form-group">
            <label>Image (optional):</label>
            <input type="file" name="image" accept="image/*">
        </div>
        
        <button type="submit">Test Update</button>
    </form>
    
    <div id="result" class="result" style="display: none;"></div>
    
    <script>
    document.getElementById('testForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const result = document.getElementById('result');
        result.style.display = 'block';
        result.innerHTML = 'Submitting...';
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                result.innerHTML = `
                    <h3 style="color: green;">✓ SUCCESS</h3>
                    <p><strong>Message:</strong> ${data.message}</p>
                    <pre>${JSON.stringify(data.data, null, 2)}</pre>
                `;
            } else {
                result.innerHTML = `
                    <h3 style="color: red;">✗ FAILED</h3>
                    <p><strong>Error:</strong> ${data.error}</p>
                    <p><strong>File:</strong> ${data.file}</p>
                    <p><strong>Line:</strong> ${data.line}</p>
                `;
            }
        } catch (error) {
            result.innerHTML = `
                <h3 style="color: red;">✗ NETWORK ERROR</h3>
                <p>${error.message}</p>
            `;
        }
    });
    </script>
</body>
</html>
