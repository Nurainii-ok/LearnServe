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

        $classes = Classes::where('status', 'active')->get();
        $bootcamps = Bootcamp::all();
        
        // If tutor, only show their classes/bootcamps
        if ($userRole === 'tutor') {
            $classes = $classes->where('tutor_id', $userId);
            $bootcamps = $bootcamps->where('tutor_id', $userId);
        }
        
        $viewPath = $userRole === 'admin' ? 'admin.video-contents.create' : 'tutor.video-contents.create';
        return view($viewPath, compact('classes', 'bootcamps'));
    }

    public function store(Request $request)
    {
        $userId = session('user_id');
        $userRole = session('role');
        
        if (!$userId || !in_array($userRole, ['admin', 'tutor'])) {
            return redirect()->route('auth')->with('error', 'Access denied.');
        }

        // Validate basic fields
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:1',
            'class_id' => 'nullable|exists:classes,id',
            'bootcamp_id' => 'nullable|exists:bootcamps,id',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ];

        // Add conditional validation for video source
        if ($request->filled('video_url')) {
            $rules['video_url'] = 'required|url';
        } elseif ($request->hasFile('video_file')) {
            $rules['video_file'] = 'required|file|mimes:mp4,webm,avi,mov,wmv|max:102400'; // 100MB max
        } else {
            return back()->withErrors(['error' => 'Please provide either a YouTube URL or upload a video file.'])->withInput();
        }

        $request->validate($rules);

        // Ensure either class_id or bootcamp_id is provided
        if (!$request->class_id && !$request->bootcamp_id) {
            return back()->withErrors(['error' => 'Please select either a class or bootcamp.'])->withInput();
        }

        $data = $request->only(['title', 'description', 'duration', 'class_id', 'bootcamp_id', 'order', 'status']);
        $data['created_by'] = $userId;

        // Handle video source
        if ($request->filled('video_url')) {
            // YouTube URL
            $data['video_url'] = $request->video_url;
            $data['video_type'] = 'youtube';
        } elseif ($request->hasFile('video_file')) {
            // Video file upload
            $videoFile = $request->file('video_file');
            $videoPath = $videoFile->store('video-uploads', 'public');
            $data['video_url'] = $videoPath;
            $data['video_type'] = 'upload';
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('video-thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        VideoContent::create($data);

        return redirect()->route($this->getIndexRoute())->with('success', 'Video content created successfully.');
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

    /**
 * Convert YouTube URL to Embed format
 */
private function convertYoutubeUrlToEmbed($url)
{
    // Format: https://youtu.be/VIDEO_ID
    if (preg_match('/youtu\.be\/([^\?]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Format: https://www.youtube.com/watch?v=VIDEO_ID
    if (preg_match('/watch\?v=([^&]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    return $url; // fallback
}

}
