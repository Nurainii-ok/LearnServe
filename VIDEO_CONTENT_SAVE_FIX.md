# Video Content Save Issue Fix

## Masalah
Data tidak masuk ke database saat save video content, kemungkinan karena:
1. Column `video_type` belum ada di database
2. Konflik antara `video_url` dan `youtube_url` di model
3. Migration belum dijalankan
4. Error tidak ter-handle dengan baik

## Root Cause Analysis
1. **Migration Issue**: Migration `add_video_type_to_video_contents_table.php` kosong
2. **Model Fillable**: Field `video_type` di fillable tapi column belum ada
3. **Controller Logic**: Mencoba insert `video_type` yang belum ada
4. **Error Handling**: Tidak ada try-catch untuk debug

## Solusi yang Diterapkan

### 1. **Migration Fix**

**File: `database/migrations/2025_09_23_063541_add_video_type_to_video_contents_table.php`**

**Before (Empty):**
```php
public function up(): void
{
    Schema::table('video_contents', function (Blueprint $table) {
        //
    });
}
```

**After (Complete):**
```php
public function up(): void
{
    Schema::table('video_contents', function (Blueprint $table) {
        $table->string('video_type')->nullable()->after('video_url'); // 'upload' or 'youtube'
    });
}

public function down(): void
{
    Schema::table('video_contents', function (Blueprint $table) {
        $table->dropColumn('video_type');
    });
}
```

### 2. **Controller Error Handling**

**File: `app/Http/Controllers/VideoContentController.php`**

**Before (No Error Handling):**
```php
VideoContent::create($data);
return redirect()->route($this->getIndexRoute())->with('success', 'Video content created successfully.');
```

**After (With Try-Catch & Debug):**
```php
try {
    // Debug: Log the data being inserted
    \Log::info('Creating VideoContent with data:', $data);
    
    $videoContent = VideoContent::create($data);
    
    \Log::info('VideoContent created successfully with ID: ' . $videoContent->id);
    
    return redirect()->route($this->getIndexRoute())->with('success', 'Video content created successfully.');
} catch (\Exception $e) {
    \Log::error('Error creating VideoContent: ' . $e->getMessage());
    \Log::error('Stack trace: ' . $e->getTraceAsString());
    
    return back()->withErrors(['error' => 'Failed to create video content: ' . $e->getMessage()])->withInput();
}
```

### 3. **Video Source Handling Fix**

**Before (Potential Column Error):**
```php
if ($request->filled('video_url')) {
    $data['video_url'] = $request->video_url;
    $data['video_type'] = 'youtube'; // Column might not exist
} elseif ($request->hasFile('video_file')) {
    $videoPath = $videoFile->store('video-uploads', 'public');
    $data['video_url'] = $videoPath;
    $data['video_type'] = 'upload'; // Column might not exist
}
```

**After (Safe Handling):**
```php
if ($request->filled('video_url')) {
    // YouTube URL
    $data['youtube_url'] = $request->video_url;
    $data['video_url'] = $request->video_url; // Keep both for compatibility
    // Remove video_type for now since column might not exist
    // $data['video_type'] = 'youtube';
} elseif ($request->hasFile('video_file')) {
    // Video file upload
    $videoFile = $request->file('video_file');
    $videoPath = $videoFile->store('video-uploads', 'public');
    $data['video_url'] = $videoPath;
    // Remove video_type for now since column might not exist
    // $data['video_type'] = 'upload';
}
```

### 4. **Model Fillable Temporary Fix**

**File: `app/Models/VideoContent.php`**

**Before (Potential Error):**
```php
protected $fillable = [
    'title',
    'description',
    'video_url',
    'youtube_url',
    'video_type', // Column might not exist
    // ...
];
```

**After (Safe):**
```php
protected $fillable = [
    'title',
    'description',
    'video_url',
    'youtube_url',
    // 'video_type', // Temporarily removed until migration is run
    // ...
];
```

## Langkah-Langkah Perbaikan

### 🔧 **Step 1: Run Migration**
```bash
php artisan migrate
```

### 🔧 **Step 2: Enable video_type (After Migration)**
Setelah migration berhasil, uncomment di model:
```php
// In app/Models/VideoContent.php
protected $fillable = [
    // ...
    'video_type', // Uncomment this line
    // ...
];
```

### 🔧 **Step 3: Enable video_type in Controller (After Migration)**
Setelah migration berhasil, uncomment di controller:
```php
// In VideoContentController.php
if ($request->filled('video_url')) {
    $data['youtube_url'] = $request->video_url;
    $data['video_url'] = $request->video_url;
    $data['video_type'] = 'youtube'; // Uncomment this line
} elseif ($request->hasFile('video_file')) {
    $videoFile = $request->file('video_file');
    $videoPath = $videoFile->store('video-uploads', 'public');
    $data['video_url'] = $videoPath;
    $data['video_type'] = 'upload'; // Uncomment this line
}
```

### 🔧 **Step 4: Test & Debug**
1. Check logs: `tail -f storage/logs/laravel.log`
2. Try creating video content
3. Verify data in database
4. Check for any remaining errors

## Debugging Guide

### 📋 **Check Database Structure:**
```sql
DESCRIBE video_contents;
```

### 📋 **Check Logs:**
```bash
tail -f storage/logs/laravel.log | grep "VideoContent"
```

### 📋 **Test Data Insert:**
```php
// In tinker: php artisan tinker
$data = [
    'title' => 'Test Video',
    'description' => 'Test Description',
    'video_url' => 'https://youtube.com/watch?v=test',
    'youtube_url' => 'https://youtube.com/watch?v=test',
    'class_id' => 1,
    'status' => 'active',
    'created_by' => 1
];

VideoContent::create($data);
```

## Common Issues & Solutions

### ❌ **Issue: Column 'video_type' doesn't exist**
**Solution:** Run migration first
```bash
php artisan migrate
```

### ❌ **Issue: Mass assignment error**
**Solution:** Check fillable array in model

### ❌ **Issue: Foreign key constraint fails**
**Solution:** Ensure class_id exists and user has permission

### ❌ **Issue: File upload fails**
**Solution:** Check storage permissions and disk space

### ❌ **Issue: Validation fails silently**
**Solution:** Check validation rules and form data

## Files Modified

### `database/migrations/2025_09_23_063541_add_video_type_to_video_contents_table.php`
- ✅ Added video_type column definition
- ✅ Added proper down() method

### `app/Http/Controllers/VideoContentController.php`
- ✅ Added comprehensive error handling
- ✅ Added debug logging
- ✅ Temporarily disabled video_type until migration
- ✅ Fixed video source handling

### `app/Models/VideoContent.php`
- ✅ Temporarily commented out video_type from fillable
- ✅ Ready to uncomment after migration

## Testing Checklist

### ✅ **Before Migration:**
- [ ] Form loads without errors
- [ ] Validation works
- [ ] Error messages show properly

### ✅ **After Migration:**
- [ ] Migration runs successfully
- [ ] video_type column exists
- [ ] Data saves to database
- [ ] Logs show successful creation
- [ ] Redirect works properly

### ✅ **Final Testing:**
- [ ] YouTube URL saves correctly
- [ ] File upload works
- [ ] Thumbnail upload works
- [ ] All fields save properly
- [ ] No console errors

---

**Status**: 🔄 **IN PROGRESS**  
**Next Steps**: 
1. Run migration: `php artisan migrate`
2. Test video content creation
3. Enable video_type after migration success
4. Final testing and validation

**Priority**: P0 - Critical functionality broken
