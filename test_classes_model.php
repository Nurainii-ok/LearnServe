<!DOCTYPE html>
<html>
<head>
    <title>Test Classes Model</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; margin: 5px; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h2>Test Classes Model - Database Compatibility</h2>
    
    <button onclick="testModel()">Test Model Fillable Fields</button>
    <button onclick="testCreate()">Test Create Class</button>
    <button onclick="testUpdate()">Test Update Class</button>
    <button onclick="testDatabase()">Test Database Structure</button>
    
    <div id="result"></div>

    <script>
    async function testModel() {
        const result = document.getElementById('result');
        result.innerHTML = 'Testing model fillable fields...';
        
        try {
            const response = await fetch('/test-model-fillable', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            });
            
            const data = await response.json();
            
            if (data.success) {
                result.innerHTML = `
                    <div class="success">✓ Model Test SUCCESS</div>
                    <p><strong>Fillable Fields:</strong></p>
                    <pre>${JSON.stringify(data.fillable, null, 2)}</pre>
                    <p><strong>Database Columns:</strong></p>
                    <pre>${JSON.stringify(data.columns, null, 2)}</pre>
                `;
            } else {
                result.innerHTML = `
                    <div class="error">✗ Model Test FAILED</div>
                    <p>${data.error}</p>
                `;
            }
        } catch (error) {
            result.innerHTML = `<div class="error">Network Error: ${error.message}</div>`;
        }
    }
    
    async function testCreate() {
        const result = document.getElementById('result');
        result.innerHTML = 'Testing class creation...';
        
        try {
            const response = await fetch('/test-create-class', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    title: 'Test Class ' + Date.now(),
                    description: 'Test description',
                    tutor_id: 1,
                    price: 100000,
                    status: 'active',
                    category: 'Test'
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                result.innerHTML = `
                    <div class="success">✓ Create Test SUCCESS</div>
                    <p><strong>Created Class:</strong></p>
                    <pre>${JSON.stringify(data.class, null, 2)}</pre>
                `;
            } else {
                result.innerHTML = `
                    <div class="error">✗ Create Test FAILED</div>
                    <p>${data.error}</p>
                `;
            }
        } catch (error) {
            result.innerHTML = `<div class="error">Network Error: ${error.message}</div>`;
        }
    }
    
    async function testUpdate() {
        const result = document.getElementById('result');
        result.innerHTML = 'Testing class update...';
        
        try {
            const response = await fetch('/test-update-class/1', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    title: 'Updated Test Class ' + Date.now(),
                    description: 'Updated description',
                    tutor_id: 1,
                    price: 150000,
                    status: 'active',
                    category: 'Updated'
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                result.innerHTML = `
                    <div class="success">✓ Update Test SUCCESS</div>
                    <p><strong>Updated Class:</strong></p>
                    <pre>${JSON.stringify(data.class, null, 2)}</pre>
                `;
            } else {
                result.innerHTML = `
                    <div class="error">✗ Update Test FAILED</div>
                    <p>${data.error}</p>
                `;
            }
        } catch (error) {
            result.innerHTML = `<div class="error">Network Error: ${error.message}</div>`;
        }
    }
    
    async function testDatabase() {
        const result = document.getElementById('result');
        result.innerHTML = 'Testing database structure...';
        
        try {
            const response = await fetch('/test-database-structure');
            const data = await response.json();
            
            result.innerHTML = `
                <div class="info">Database Structure Info</div>
                <p><strong>Classes Table Columns:</strong></p>
                <pre>${JSON.stringify(data.columns, null, 2)}</pre>
                <p><strong>Sample Class Data:</strong></p>
                <pre>${JSON.stringify(data.sample_class, null, 2)}</pre>
            `;
        } catch (error) {
            result.innerHTML = `<div class="error">Network Error: ${error.message}</div>`;
        }
    }
    </script>
</body>
</html>
