<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\Payment;
use App\Models\Task;
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
        
        // Get task progress for enrolled classes
        $enrolledClassIds = $memberEnrollments->where('type', 'class')
            ->pluck('class_id')
            ->filter();
            
        // Get all tasks for enrolled classes
        $allTasks = Task::whereIn('class_id', $enrolledClassIds)->count();
        
        // Get completed tasks (submitted and graded)
        $completedTasks = \App\Models\TaskSubmission::whereHas('task', function($query) use ($enrolledClassIds) {
            $query->whereIn('class_id', $enrolledClassIds);
        })
        ->where('user_id', $memberId)
        ->whereNotNull('grade')
        ->count();
        
        // Get pending tasks
        $pendingTasks = \App\Models\TaskSubmission::whereHas('task', function($query) use ($enrolledClassIds) {
            $query->whereIn('class_id', $enrolledClassIds);
        })
        ->where('user_id', $memberId)
        ->whereNull('grade')
        ->count();
        
        // Get not submitted tasks
        $submittedTaskIds = \App\Models\TaskSubmission::where('user_id', $memberId)->pluck('task_id');
        $notSubmittedTasks = Task::whereIn('class_id', $enrolledClassIds)
            ->whereNotIn('id', $submittedTaskIds)
            ->count();
            
        // Calculate progress percentage
        $taskProgressPercentage = $allTasks > 0 ? round(($completedTasks / $allTasks) * 100, 1) : 0;
        
        // Get certificates count
        $certificatesCount = \App\Models\Certificate::where('user_id', $memberId)
            ->where('status', 'active')
            ->count();
            
        // Get bootcamp progress
        $certificateService = new \App\Services\CertificateService();
        $bootcampProgress = [];
        
        foreach ($memberEnrollments->where('type', 'bootcamp') as $enrollment) {
            $progress = $certificateService->getBootcampProgress($memberId, $enrollment->bootcamp_id);
            $bootcampProgress[$enrollment->bootcamp_id] = $progress;
        }
            
        // Get upcoming tasks
        $upcomingTasks = Task::whereIn('class_id', $enrolledClassIds)
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
            'memberEnrollments',
            'allTasks',
            'completedTasks',
            'pendingTasks',
            'notSubmittedTasks',
            'taskProgressPercentage',
            'certificatesCount',
            'bootcampProgress'
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
            ->with(['class', 'assignedBy', 'submissions'])
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
            return redirect()->back()->with('error', 'You are not enrolled in this class.');
        }
        
        // Validate the submission
        $request->validate([
            'submission_text' => 'nullable|string|max:2000',
            'submission_file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,zip,rar,jpg,jpeg,png'
        ]);
        
        // Check if at least one field is provided
        if (!$request->submission_text && !$request->hasFile('submission_file')) {
            return redirect()->back()->with('error', 'Please provide either a description or upload a file.');
        }
        
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('submission_file')) {
            $file = $request->file('submission_file');
            $fileName = time() . '_' . $memberId . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('task-submissions', $fileName, 'public');
        }
        
        // Check if user already submitted this task
        $existingSubmission = \App\Models\TaskSubmission::where('task_id', $taskId)
            ->where('user_id', $memberId)
            ->first();
            
        if ($existingSubmission) {
            // Update existing submission
            $existingSubmission->update([
                'content' => $request->submission_text,
                'file_path' => $filePath ?: $existingSubmission->file_path, // Keep old file if no new file
                'original_filename' => $request->hasFile('submission_file') ? $request->file('submission_file')->getClientOriginalName() : $existingSubmission->original_filename
            ]);
            
            return redirect()->back()->with('success', 'Task submission updated successfully! Your tutor will review the updated version.');
        } else {
            // Create new submission
            \App\Models\TaskSubmission::create([
                'task_id' => $taskId,
                'user_id' => $memberId,
                'content' => $request->submission_text,
                'file_path' => $filePath,
                'original_filename' => $request->hasFile('submission_file') ? $request->file('submission_file')->getClientOriginalName() : null
            ]);
            
            return redirect()->back()->with('success', 'Task submitted successfully! Your tutor will review it soon.');
        }
    }
}
