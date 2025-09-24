<!DOCTYPE html>
<html>
<head>
    <title>Simple Edit Test</title>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
</head>
<body>
    <h2>Simple Edit Test - Class ID 1</h2>
    
    <form action="/admin/classes/1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="_method" value="PUT">
        
        <p>
            <label>Title:</label><br>
            <input type="text" name="title" value="Rosblox Test Update" required>
        </p>
        
        <p>
            <label>Description:</label><br>
            <textarea name="description" required>Test description update</textarea>
        </p>
        
        <p>
            <label>Tutor ID:</label><br>
            <input type="number" name="tutor_id" value="1" required>
        </p>
        
        <p>
            <label>Price:</label><br>
            <input type="number" name="price" value="200000" required>
        </p>
        
        <p>
            <label>Status:</label><br>
            <select name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </p>
        
        <p>
            <label>Category:</label><br>
            <input type="text" name="category" value="Self Development">
        </p>
        
        <p>
            <button type="submit">Update Class (No Image)</button>
        </p>
    </form>
    
    <hr>
    
    <h3>Test with Image:</h3>
    <form action="/admin/classes/1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="_method" value="PUT">
        
        <p>
            <label>Title:</label><br>
            <input type="text" name="title" value="Rosblox With Image" required>
        </p>
        
        <p>
            <label>Description:</label><br>
            <textarea name="description" required>Test description with image</textarea>
        </p>
        
        <p>
            <label>Tutor ID:</label><br>
            <input type="number" name="tutor_id" value="1" required>
        </p>
        
        <p>
            <label>Price:</label><br>
            <input type="number" name="price" value="250000" required>
        </p>
        
        <p>
            <label>Status:</label><br>
            <select name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </p>
        
        <p>
            <label>Category:</label><br>
            <input type="text" name="category" value="Self Development">
        </p>
        
        <p>
            <label>Image:</label><br>
            <input type="file" name="image" accept="image/*">
        </p>
        
        <p>
            <button type="submit">Update Class (With Image)</button>
        </p>
    </form>
</body>
</html>
