<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoContent;
use App\Models\Classes;
use App\Models\Bootcamp;
use Illuminate\Support\Facades\Storage;

class VideoContentController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        $query = VideoContent::with(['class', 'bootcamp', 'creator']);
        
        // If tutor, only show their content
        if ($userRole === 'tutor') {
            $query->where('created_by', $userId);
        }
        
        $videos = $query->latest()->paginate(10);
        
        $viewPath = $userRole === 'admin' ? 'admin.video-contents.index' : 'tutor.video-contents.index';
        return view($viewPath, compact('videos'));
    }

    public function create()
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // Only get classes - video content is only for classes
        if ($userRole === 'tutor') {
            // For tutor, get their classes only
            $classes = Classes::where('tutor_id', $userId)
                             ->where('status', 'active')
                             ->get();
        } else {
            // For admin, get all active classes
            $classes = Classes::where('status', 'active')->get();
        }
        
        // Debug: Check if classes exist
        \Log::info('Video Content Create - Classes count: ' . $classes->count());
        \Log::info('User ID: ' . $userId . ', Role: ' . $userRole);
        if ($classes->count() > 0) {
            \Log::info('First class: ' . $classes->first()->title);
        }
        
        $viewPath = $userRole === 'admin' ? 'admin.video-contents.create' : 'tutor.video-contents.create';
        return view($viewPath, compact('classes'));
    }

    public function store(Request $request)
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // Validate basic fields - only classes supported
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:1',
            'class_id' => 'required|exists:classes,id',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ];

        // Add conditional validation for video source
        if ($request->filled('video_url')) {
            $rules['video_url'] = 'required|url';
            \Log::info('Validating YouTube URL: ' . $request->video_url);
        } elseif ($request->hasFile('video_file')) {
            $rules['video_file'] = 'required|file|mimes:mp4,webm,avi,mov,wmv|max:102400'; // 100MB max
            \Log::info('Validating video file upload');
        } else {
            \Log::error('No video source provided');
            return back()->withErrors(['video_source' => 'Please provide either a YouTube URL or upload a video file.'])->withInput();
        }

        try {
            $request->validate($rules);
            \Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());
            throw $e;
        }

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

        // Handle video source
        if ($request->filled('video_url')) {
            // YouTube URL
            $data['youtube_url'] = $request->video_url;
            $data['video_url'] = $request->video_url;
        } elseif ($request->hasFile('video_file')) {
            // Video file upload
            $videoFile = $request->file('video_file');
            
            // Debug file info
            \Log::info('Video file info:', [
                'original_name' => $videoFile->getClientOriginalName(),
                'size' => $videoFile->getSize(),
                'mime_type' => $videoFile->getMimeType(),
                'extension' => $videoFile->getClientOriginalExtension()
            ]);
            
            // Store the file
            $videoPath = $videoFile->store('video-uploads', 'public');
            \Log::info('Video stored at path: ' . $videoPath);
            
            $data['video_url'] = $videoPath;
        } else {
            return back()->withErrors(['error' => 'Please provide either a YouTube URL or upload a video file.'])->withInput();
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('video-thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        try {
            // Debug: Log all request data
            \Log::info('VideoContent Store Request Data:', $request->all());
            \Log::info('VideoContent Store Files:', $request->allFiles());
            \Log::info('VideoContent Store Data to Insert:', $data);
            
            // Create the video content
            $videoContent = VideoContent::create($data);
            
            \Log::info('VideoContent created successfully with ID: ' . $videoContent->id);
            \Log::info('VideoContent data: ', $videoContent->toArray());
            
            return redirect()->route($this->getIndexRoute())->with('success', 'Video content created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating VideoContent: ' . $e->getMessage());
            \Log::error('Request data: ', $request->all());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withErrors(['error' => 'Failed to create video content: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(VideoContent $videoContent)
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // If tutor, check ownership
        if ($userRole === 'tutor' && $videoContent->created_by !== $userId) {
            return redirect()->route('tutor.video-contents.index')->with('error', 'Access denied.');
        }

        $videoContent->load(['class', 'bootcamp', 'creator']);
        
        $viewPath = $userRole === 'admin' ? 'admin.video-contents.show' : 'tutor.video-contents.show';
        return view($viewPath, compact('videoContent'));
    }

    public function edit(VideoContent $videoContent)
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // If tutor, check ownership
        if ($userRole === 'tutor' && $videoContent->created_by !== $userId) {
            return redirect()->route('tutor.video-contents.index')->with('error', 'Access denied.');
        }

        $classes = Classes::where('status', 'active')->get();
        $bootcamps = Bootcamp::all();
        
        // If tutor, only show their classes/bootcamps
        if ($userRole === 'tutor') {
            $classes = $classes->where('tutor_id', $userId);
            $bootcamps = $bootcamps->where('tutor_id', $userId);
        }
        
        $viewPath = $userRole === 'admin' ? 'admin.video-contents.edit' : 'tutor.video-contents.edit';
        return view($viewPath, compact('videoContent', 'classes', 'bootcamps'));
    }

    public function update(Request $request, VideoContent $videoContent)
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // If tutor, check ownership
        if ($userRole === 'tutor' && $videoContent->created_by !== $userId) {
            return redirect()->route('tutor.video-contents.index')->with('error', 'Access denied.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:1',
            'class_id' => 'nullable|exists:classes,id',
            'bootcamp_id' => 'nullable|exists:bootcamps,id',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        // Ensure either class_id or bootcamp_id is provided
        if (!$request->class_id && !$request->bootcamp_id) {
            return back()->withErrors(['error' => 'Please select either a class or bootcamp.'])->withInput();
        }

        $data = $request->all();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($videoContent->thumbnail) {
                Storage::disk('public')->delete($videoContent->thumbnail);
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('video-thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $videoContent->update($data);

        $routeName = $userRole === 'admin' ? 'admin.video-contents.index' : 'tutor.video-contents.index';
        return redirect()->route($routeName)->with('success', 'Video content updated successfully.');
    }

    public function destroy(VideoContent $videoContent)
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // If tutor, check ownership
        if ($userRole === 'tutor' && $videoContent->created_by !== $userId) {
            return redirect()->route('tutor.video-contents.index')->with('error', 'Access denied.');
        }

        // Delete thumbnail if exists
        if ($videoContent->thumbnail) {
            Storage::disk('public')->delete($videoContent->thumbnail);
        }

        $videoContent->delete();

        $routeName = session('role') === 'admin' ? 'admin.video-contents.index' : 'tutor.video-contents.index';
        return redirect()->route($routeName)->with('success', 'Video content deleted successfully.');
    }
    
    /**
     * Get the correct route name based on user role
     */
    private function getIndexRoute()
    {
        return session('role') === 'admin' ? 'admin.video-contents.index' : 'tutor.video-contents.index';
    }
}
