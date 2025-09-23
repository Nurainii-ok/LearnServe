# Video Upload Troubleshooting Guide

## Masalah
Upload video masih belum masuk ke database meskipun form sudah diperbaiki.

## Langkah Troubleshooting

### 🔍 **Step 1: Test Manual Insert**
```bash
cd d:\laragon\www\LearnServe-1
php test_video_upload.php
```

Ini akan test apakah model dan database bisa insert data dengan benar.

### 🔍 **Step 2: Check Logs**
```bash
tail -f storage/logs/laravel.log
```

Atau buka file: `storage/logs/laravel-2025-09-23.log`

### 🔍 **Step 3: Test Form Submission**
1. Buka form create video content
2. Fill semua field yang required
3. Upload video atau masukkan YouTube URL
4. Submit form
5. Check logs untuk melihat data yang dikirim

### 🔍 **Step 4: Check Storage**
Pastikan storage link ada:
```bash
php artisan storage:link
```

Check folder permissions:
- `storage/app/public/video-uploads/` harus writable
- `storage/app/public/video-thumbnails/` harus writable

### 🔍 **Step 5: Database Check**
```sql
-- Check table structure
DESCRIBE video_contents;

-- Check if data exists
SELECT * FROM video_contents ORDER BY id DESC LIMIT 5;

-- Check classes
SELECT id, title, tutor_id FROM classes WHERE status = 'active';
```

## Perbaikan yang Sudah Diterapkan

### 1. **Enhanced Logging**
```php
// Debug: Log all request data
\Log::info('VideoContent Store Request Data:', $request->all());
\Log::info('VideoContent Store Files:', $request->allFiles());
\Log::info('VideoContent Store Data to Insert:', $data);

// File upload logging
\Log::info('Video file info:', [
    'original_name' => $videoFile->getClientOriginalName(),
    'size' => $videoFile->getSize(),
    'mime_type' => $videoFile->getMimeType(),
    'extension' => $videoFile->getClientOriginalExtension()
]);
```

### 2. **Simplified Data Preparation**
```php
// Prepare data for insertion
$data = [
    'title' => $request->title,
    'description' => $request->description,
    'duration' => $request->duration,
    'class_id' => $request->class_id,
    'order' => $request->order ?? 0,
    'status' => $request->status ?? 'active',
    'created_by' => $userId
];
```

### 3. **Model Cleanup**
```php
protected $fillable = [
    'title',
    'description',
    'video_url',
    'youtube_url',
    'thumbnail',
    'duration',
    'class_id',
    // Removed: 'bootcamp_id', 'video_type'
    'order',
    'status',
    'created_by'
];
```

### 4. **Better Error Handling**
```php
try {
    $videoContent = VideoContent::create($data);
    \Log::info('VideoContent created successfully with ID: ' . $videoContent->id);
    return redirect()->route($this->getIndexRoute())->with('success', 'Video content created successfully.');
} catch (\Exception $e) {
    \Log::error('Error creating VideoContent: ' . $e->getMessage());
    return back()->withErrors(['error' => 'Failed to create video content: ' . $e->getMessage()])->withInput();
}
```

## Common Issues & Solutions

### ❌ **Issue: No logs appearing**
**Cause:** Log level atau file permissions
**Solution:** 
```bash
# Check log file exists and writable
ls -la storage/logs/
chmod 755 storage/logs/
```

### ❌ **Issue: File upload fails**
**Cause:** Storage link missing atau permissions
**Solution:**
```bash
php artisan storage:link
chmod -R 755 storage/
```

### ❌ **Issue: Class not found**
**Cause:** Tutor belum punya classes
**Solution:** Create class terlebih dahulu

### ❌ **Issue: Validation fails**
**Cause:** Required fields kosong
**Solution:** Check form validation dan required fields

### ❌ **Issue: Route not found**
**Cause:** Route cache atau naming issue
**Solution:**
```bash
php artisan route:clear
php artisan route:cache
```

## Testing Checklist

### ✅ **Form Testing:**
- [ ] Form loads without errors
- [ ] All fields are fillable
- [ ] File upload input works
- [ ] YouTube URL input works
- [ ] Class dropdown has options
- [ ] Submit button enabled

### ✅ **Backend Testing:**
- [ ] Route exists and accessible
- [ ] Controller method executes
- [ ] Validation passes
- [ ] File uploads successfully
- [ ] Data inserts to database
- [ ] Redirect works properly

### ✅ **Database Testing:**
- [ ] Table `video_contents` exists
- [ ] All required columns exist
- [ ] Foreign keys are valid
- [ ] Data types match
- [ ] No constraint violations

### ✅ **File System Testing:**
- [ ] Storage link exists
- [ ] Upload directories exist
- [ ] Permissions are correct
- [ ] Disk space available

## Debug Commands

### 📋 **Laravel Commands:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check routes
php artisan route:list | grep video

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check storage
php artisan storage:link
```

### 📋 **Database Commands:**
```sql
-- Check video_contents table
SHOW CREATE TABLE video_contents;

-- Check recent inserts
SELECT * FROM video_contents ORDER BY created_at DESC LIMIT 5;

-- Check classes for tutor
SELECT * FROM classes WHERE tutor_id = [TUTOR_ID];
```

### 📋 **File System Commands:**
```bash
# Check storage structure
ls -la storage/app/public/
ls -la public/storage/

# Check permissions
ls -la storage/
chmod -R 755 storage/
```

## Expected Log Output

### ✅ **Successful Upload:**
```
[2025-09-23 21:30:00] local.INFO: VideoContent Store Request Data: {"title":"Test Video","description":"Test","class_id":"1",...}
[2025-09-23 21:30:00] local.INFO: VideoContent Store Files: {"video_file":{...}}
[2025-09-23 21:30:00] local.INFO: Video file info: {"original_name":"test.mp4","size":1048576,...}
[2025-09-23 21:30:00] local.INFO: Video stored at path: video-uploads/abc123.mp4
[2025-09-23 21:30:00] local.INFO: VideoContent Store Data to Insert: {"title":"Test Video",...}
[2025-09-23 21:30:00] local.INFO: VideoContent created successfully with ID: 1
```

### ❌ **Failed Upload:**
```
[2025-09-23 21:30:00] local.ERROR: Error creating VideoContent: [specific error message]
[2025-09-23 21:30:00] local.ERROR: Request data: {...}
[2025-09-23 21:30:00] local.ERROR: Stack trace: [detailed trace]
```

---

**Next Steps:**
1. Run test script: `php test_video_upload.php`
2. Try form submission dengan logging enabled
3. Check logs untuk specific error
4. Report findings untuk further debugging

**Priority:** P0 - Critical functionality broken
