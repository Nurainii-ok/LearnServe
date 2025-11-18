<!DOCTYPE html>
<html>
<head>
    <title>Quick Test Update</title>
</head>
<body>
    <h2>Quick Test - Class Update</h2>
    
    <button onclick="testUpdate()">Test Update Class ID 1</button>
    <button onclick="testDebugInfo()">Get Debug Info</button>
    
    <div id="result" style="margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px;"></div>

    <script>
    async function testUpdate() {
        const result = document.getElementById('result');
        result.innerHTML = 'Testing update...';
        
        try {
            const response = await fetch('/test-class-update/1', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    title: 'Test Update ' + Date.now(),
                    description: 'Test description updated',
                    tutor_id: 1,
                    price: 150000,
                    status: 'active',
                    category: 'Test Category'
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                result.innerHTML = `
                    <h3 style="color: green;">✓ SUCCESS</h3>
                    <p><strong>Message:</strong> ${data.message}</p>
                    <p><strong>Updated Data:</strong></p>
                    <pre>${JSON.stringify(data.updated_data, null, 2)}</pre>
                    <p><strong>Class Data:</strong></p>
                    <pre>${JSON.stringify(data.class, null, 2)}</pre>
                `;
            } else {
                result.innerHTML = `
                    <h3 style="color: red;">✗ FAILED</h3>
                    <p><strong>Error:</strong> ${data.error}</p>
                    <pre>${data.trace}</pre>
                `;
            }
        } catch (error) {
            result.innerHTML = `
                <h3 style="color: red;">✗ NETWORK ERROR</h3>
                <p>${error.message}</p>
            `;
        }
    }
    
    async function testDebugInfo() {
        const result = document.getElementById('result');
        result.innerHTML = 'Getting debug info...';
        
        try {
            const response = await fetch('/debug-class-update/1');
            const data = await response.json();
            
            result.innerHTML = `
                <h3>Debug Information</h3>
                <p><strong>Class Found:</strong> ${data.class.title}</p>
                <p><strong>Tutors Count:</strong> ${data.tutors_count}</p>
                <p><strong>Upload Dir Exists:</strong> ${data.upload_dir_exists ? 'Yes' : 'No'}</p>
                <p><strong>Upload Dir Writable:</strong> ${data.upload_dir_writable ? 'Yes' : 'No'}</p>
                <p><strong>PHP Settings:</strong></p>
                <pre>${JSON.stringify(data.php_settings, null, 2)}</pre>
                <p><strong>Full Class Data:</strong></p>
                <pre>${JSON.stringify(data.class, null, 2)}</pre>
            `;
        } catch (error) {
            result.innerHTML = `
                <h3 style="color: red;">✗ ERROR</h3>
                <p>${error.message}</p>
            `;
        }
    }
    </script>
</body>
</html>
