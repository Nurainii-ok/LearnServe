<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoContent;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\Enrollment;

class ELearningController extends Controller
{
    public function index()
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }

        // Get member's active enrollments
        $enrollments = Enrollment::where('user_id', $memberId)
            ->where('status', 'active')
            ->with(['class', 'bootcamp'])
            ->latest()
            ->get();

        return view('member.elearning.index', compact('enrollments'));
    }

    public function showClass($classId)
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }

        // Check if member is enrolled in this class
        $enrollment = Enrollment::where('user_id', $memberId)
            ->where('class_id', $classId)
            ->where('type', 'class')
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return redirect()->route('elearning.index')->with('error', 'You are not enrolled in this class.');
        }

        $class = Classes::with('tutor')->findOrFail($classId);
        
        // Get video contents for this class
        $videos = VideoContent::where('class_id', $classId)
            ->where('status', 'active')
            ->ordered()
            ->get();

        return view('member.elearning.class', compact('class', 'videos', 'enrollment'));
    }

    public function showBootcamp($bootcampId)
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }

        // Check if member is enrolled in this bootcamp
        $enrollment = Enrollment::where('user_id', $memberId)
            ->where('bootcamp_id', $bootcampId)
            ->where('type', 'bootcamp')
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return redirect()->route('elearning.index')->with('error', 'You are not enrolled in this bootcamp.');
        }

        $bootcamp = Bootcamp::with('tutor')->findOrFail($bootcampId);
        
        // Get video contents for this bootcamp
        $videos = VideoContent::where('bootcamp_id', $bootcampId)
            ->where('status', 'active')
            ->ordered()
            ->get();

        return view('member.elearning.bootcamp', compact('bootcamp', 'videos', 'enrollment'));
    }

    public function watchVideo($videoId)
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }

        $video = VideoContent::with(['class', 'bootcamp'])->findOrFail($videoId);

        // Check if member is enrolled
        $enrollment = null;
        if ($video->class_id) {
            $enrollment = Enrollment::where('user_id', $memberId)
                ->where('class_id', $video->class_id)
                ->where('type', 'class')
                ->where('status', 'active')
                ->first();
        } elseif ($video->bootcamp_id) {
            $enrollment = Enrollment::where('user_id', $memberId)
                ->where('bootcamp_id', $video->bootcamp_id)
                ->where('type', 'bootcamp')
                ->where('status', 'active')
                ->first();
        }

        if (!$enrollment) {
            return redirect()->route('elearning.index')->with('error', 'You are not enrolled in this course.');
        }

        // Get other videos in the same course for navigation
        $otherVideos = VideoContent::where(function($query) use ($video) {
                if ($video->class_id) {
                    $query->where('class_id', $video->class_id);
                } else {
                    $query->where('bootcamp_id', $video->bootcamp_id);
                }
            })
            ->where('status', 'active')
            ->where('id', '!=', $video->id)
            ->ordered()
            ->get();

        return view('member.elearning.watch', compact('video', 'otherVideos', 'enrollment'));
    }
}
