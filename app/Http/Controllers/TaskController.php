<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Classes;
use App\Models\TaskSubmission;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    // Tutor Methods
    public function tutorIndex()
    {
        
        $tasks = Task::with(['class', 'submissions'])
                    ->forTutor(Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('tutor.tasks.index', compact('tasks'));
    }

    public function tutorCreate()
    {
        
        $classes = Classes::where('tutor_id', Auth::id())->get();
        
        return view('tutor.tasks.create', compact('classes'));
    }

    public function tutorStore(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date|after:now',
            'priority' => 'required|in:low,medium,high',
            'instructions' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:10240' // 10MB max per file
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task-attachments', 'public');
                $attachments[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize()
                ];
            }
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
            'assigned_by' => Auth::id(),
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'instructions' => $request->instructions,
            'attachments' => $attachments
        ]);

        return redirect()->route('tutor.tasks.index')
                        ->with('success', 'Task created successfully!');
    }

    public function tutorShow(Task $task)
    {
        
        // Ensure tutor can only view their own tasks
        if ($task->assigned_by !== Auth::id()) {
            abort(403);
        }

        $submissions = TaskSubmission::with('user')
                                   ->where('task_id', $task->id)
                                   ->latest()
                                   ->get();

        return view('tutor.tasks.show', compact('task', 'submissions'));
    }

    public function tutorGrade(Request $request, TaskSubmission $submission)
    {
        
        // Ensure tutor can only grade their own task submissions
        if ($submission->task->assigned_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'grade' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'graded_at' => now(),
            'graded_by' => Auth::id()
        ]);

        return redirect()->back()
                        ->with('success', 'Submission graded successfully!');
    }

    public function tutorEdit(Task $task)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('auth')->with('error', 'Please login first.');
        }
        
        // Ensure tutor can only edit their own tasks
        if ($task->assigned_by !== $user->id) {
            abort(403);
        }

        $classes = Classes::where('tutor_id', $user->id)->get();
        
        return view('tutor.tasks.edit', compact('task', 'classes'));
    }

    public function tutorUpdate(Request $request, Task $task)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('auth')->with('error', 'Please login first.');
        }
        
        // Ensure tutor can only update their own tasks
        if ($task->assigned_by !== $user->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date|after:now',
            'priority' => 'required|in:low,medium,high',
            'instructions' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:10240'
        ]);

        $attachments = $task->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task-attachments', 'public');
                $attachments[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize()
                ];
            }
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'instructions' => $request->instructions,
            'attachments' => $attachments
        ]);

        return redirect()->route('tutor.tasks.index')
                        ->with('success', 'Task updated successfully!');
    }

    public function tutorDestroy(Task $task)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('auth')->with('error', 'Please login first.');
        }
        
        // Ensure tutor can only delete their own tasks
        if ($task->assigned_by !== $user->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tutor.tasks.index')
                        ->with('success', 'Task deleted successfully!');
    }

    // Member Methods
    public function memberIndex()
    {
        $user = Auth::user();
        
        // Get tasks from enrolled classes
        $enrolledClassIds = $user->enrollments()->pluck('class_id');
        
        $tasks = Task::with(['class', 'submissions' => function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    }])
                    ->whereIn('class_id', $enrolledClassIds)
                    ->latest()
                    ->paginate(10);

        return view('member.tasks.index', compact('tasks'));
    }

    public function memberShow(Task $task)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in the class
        $isEnrolled = $user->enrollments()
                         ->where('class_id', $task->class_id)
                         ->exists();
        
        if (!$isEnrolled) {
            abort(403, 'You are not enrolled in this class.');
        }

        $submission = TaskSubmission::where('task_id', $task->id)
                                   ->where('user_id', $user->id)
                                   ->first();

        return view('member.tasks.show', compact('task', 'submission'));
    }

    public function memberSubmit(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // Check if user is enrolled
        $isEnrolled = $user->enrollments()
                         ->where('class_id', $task->class_id)
                         ->exists();
        
        if (!$isEnrolled) {
            abort(403, 'You are not enrolled in this class.');
        }

        $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Check if already submitted
        $existingSubmission = TaskSubmission::where('task_id', $task->id)
                                           ->where('user_id', $user->id)
                                           ->first();

        $filePath = null;
        $originalFilename = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('task-submissions', 'public');
            $originalFilename = $file->getClientOriginalName();
        }

        if ($existingSubmission) {
            // Update existing submission
            if ($existingSubmission->file_path && $filePath) {
                Storage::disk('public')->delete($existingSubmission->file_path);
            }
            
            $existingSubmission->update([
                'content' => $request->content,
                'file_path' => $filePath ?: $existingSubmission->file_path,
                'original_filename' => $originalFilename ?: $existingSubmission->original_filename,
                // Reset grade when resubmitting
                'grade' => null,
                'feedback' => null,
                'graded_at' => null,
                'graded_by' => null
            ]);
        } else {
            // Create new submission
            TaskSubmission::create([
                'task_id' => $task->id,
                'user_id' => $user->id,
                'content' => $request->content,
                'file_path' => $filePath,
                'original_filename' => $originalFilename
            ]);
        }

        return redirect()->back()
                        ->with('success', 'Task submitted successfully!');
    }

    // Admin Methods
    public function adminIndex()
    {
        
        $tasks = Task::with(['class', 'assignedBy', 'submissions'])
                    ->latest()
                    ->paginate(15);

        return view('admin.tasks.index', compact('tasks'));
    }
}