<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\Payment;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Enrollment;
use App\Models\Grade;

class MemberController extends Controller
{
    public function dashboard()
    {
        // Get member data from session
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        $member = User::find($memberId);
        
        if (!$member || $member->role !== 'member') {
            return redirect()->route('auth')->with('error', 'Access denied. Member privileges required.');
        }
        
        // Get enrollment statistics
        $totalClasses = Classes::where('status', 'active')->count();
        $totalBootcamps = Bootcamp::count();
        
        // Get member's enrollments
        $memberEnrollments = Enrollment::where('user_id', $memberId)
            ->where('status', 'active')
            ->with(['class.tutor', 'bootcamp.tutor'])
            ->latest()
            ->get();
            
        $enrolledClassesCount = $memberEnrollments->where('type', 'class')->count();
        $enrolledBootcampsCount = $memberEnrollments->where('type', 'bootcamp')->count();
        
        // Get recent enrolled classes
        $recentClasses = $memberEnrollments->where('type', 'class')
            ->take(5)
            ->map(function($enrollment) {
                return $enrollment->class;
            })
            ->filter();
            
        // Get member's grades
        $memberGrades = Grade::where('student_id', $memberId)
            ->with(['class', 'task'])
            ->latest()
            ->take(5)
            ->get();
            
        // Calculate average grade
        $averageGrade = $memberGrades->avg('score') ?? 0;
        
        // Get upcoming tasks for enrolled classes
        $enrolledClassIds = $memberEnrollments->where('type', 'class')
            ->pluck('class_id')
            ->filter();
        $upcomingTasks = Task::whereIn('class_id', $enrolledClassIds)
            ->where('status', 'pending')
            ->where('due_date', '>', now())
            ->with(['class'])
            ->orderBy('due_date')
            ->take(5)
            ->get();
            
        return view('member.dashboard', compact(
            'member',
            'totalClasses',
            'totalBootcamps', 
            'enrolledClassesCount',
            'enrolledBootcampsCount',
            'recentClasses',
            'memberGrades',
            'averageGrade',
            'upcomingTasks',
            'memberEnrollments'
        ));
    }
    
    public function enrollments()
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get all member's enrollments with details
        $enrollments = Enrollment::where('user_id', $memberId)
            ->with(['class.tutor', 'bootcamp.tutor'])
            ->latest()
            ->paginate(10);
            
        return view('member.enrollments', compact('enrollments'));
    }
    
    public function grades()
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get all member's grades
        $grades = Grade::where('student_id', $memberId)
            ->with(['class', 'task', 'gradedBy'])
            ->latest()
            ->paginate(10);
            
        return view('member.grades', compact('grades'));
    }
    
    public function tasks()
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get enrolled classes
        $enrolledClassIds = Enrollment::where('user_id', $memberId)
            ->where('status', 'active')
            ->where('type', 'class')
            ->pluck('class_id')
            ->filter();
            
        // Get tasks for enrolled classes
        $tasks = Task::whereIn('class_id', $enrolledClassIds)
            ->with(['class', 'assignedBy', 'submissions' => function($query) {
                $query->where('user_id', session('user_id'));
            }])
            ->orderBy('due_date')
            ->paginate(10);
            
        return view('member.tasks', compact('tasks'));
    }

    public function submitTask(Request $request, $taskId)
    {
        $memberId = session('user_id');
        
        if (!$memberId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }

        // Find the task
        $task = Task::findOrFail($taskId);
        
        // Check if member is enrolled in the class
        $enrollment = Enrollment::where('user_id', $memberId)
            ->where('class_id', $task->class_id)
            ->where('status', 'active')
            ->first();
            
        if (!$enrollment) {
            return back()->withErrors(['error' => 'You are not enrolled in this class.']);
        }

        // Check if already submitted
        $existingSubmission = TaskSubmission::where('task_id', $taskId)
            ->where('user_id', $memberId)
            ->first();
            
        if ($existingSubmission) {
            return back()->withErrors(['error' => 'You have already submitted this assignment.']);
        }

        // Validate input
        $request->validate([
            'content' => 'nullable|string|max:5000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240', // 10MB max
        ]);

        // Check if at least one submission method is provided
        if (!$request->filled('content') && !$request->hasFile('file')) {
            return back()->withErrors(['error' => 'Please provide either text content or upload a file.']);
        }

        $submissionData = [
            'task_id' => $taskId,
            'user_id' => $memberId,
            'content' => $request->content,
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->store('task-submissions', 'public');
            
            $submissionData['file_path'] = $filePath;
            $submissionData['original_filename'] = $originalName;
        }

        // Create submission
        TaskSubmission::create($submissionData);

        return back()->with('success', 'Assignment submitted successfully! Your tutor will review it soon.');
    }
}
