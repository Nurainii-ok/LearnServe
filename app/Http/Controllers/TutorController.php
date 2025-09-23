<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;
use App\Models\Task;
use App\Models\Payment;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\Bootcamp;
use App\Models\VideoContent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TutorController extends Controller
{
    public function dashboard()
    {
        $tutorId = session('user_id');
        
        // Get tutor dashboard statistics using enrollments
        $totalStudents = Enrollment::where(function($query) use ($tutorId) {
            $query->whereHas('class', function($q) use ($tutorId) {
                $q->where('tutor_id', $tutorId);
            })->orWhereHas('bootcamp', function($q) use ($tutorId) {
                $q->where('tutor_id', $tutorId);
            });
        })->where('status', 'active')->distinct('user_id')->count();
        
        $totalClasses = Classes::where('tutor_id', $tutorId)->count();
        $totalBootcamps = Bootcamp::where('tutor_id', $tutorId)->count();
        
        $totalHours = ($totalClasses + $totalBootcamps) * 40; // Estimate 40 hours per course
        
        $monthlyEarnings = Payment::where(function($query) use ($tutorId) {
            $query->whereHas('class', function($q) use ($tutorId) {
                $q->where('tutor_id', $tutorId);
            })->orWhereHas('bootcamp', function($q) use ($tutorId) {
                $q->where('tutor_id', $tutorId);
            });
        })->where('status', 'completed')
          ->whereMonth('payment_date', now()->month)
          ->sum('amount');
        
        // Get recent enrollments for tutor's courses
        $recentEnrollments = Enrollment::with(['user', 'class', 'bootcamp'])
            ->where(function($query) use ($tutorId) {
                $query->whereHas('class', function($q) use ($tutorId) {
                    $q->where('tutor_id', $tutorId);
                })->orWhereHas('bootcamp', function($q) use ($tutorId) {
                    $q->where('tutor_id', $tutorId);
                });
            })
            ->latest()
            ->take(10)
            ->get();
        
        // Get recent classes with enrollment count
        $recentClasses = Classes::where('tutor_id', $tutorId)
            ->where('status', 'active')
            ->withCount(['enrollments' => function($query) {
                $query->where('status', 'active');
            }])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($class) {
                return [
                    'name' => $class->title,
                    'students' => $class->enrollments_count,
                    'next_session' => now()->addDays(rand(1, 7))->format('Y-m-d H:i:s'), // Generate random future date
                ];
            });
        
        $recentStudents = User::whereHas('enrollments', function($query) use ($tutorId) {
            $query->where(function($q) use ($tutorId) {
                $q->whereHas('class', function($subQ) use ($tutorId) {
                    $subQ->where('tutor_id', $tutorId);
                })->orWhereHas('bootcamp', function($subQ) use ($tutorId) {
                    $subQ->where('tutor_id', $tutorId);
                });
            })->where('status', 'active');
        })->where('role', 'member')
            ->latest()
            ->take(5)
            ->get();
        
        return view('tutor.dashboard', compact(
            'totalStudents', 
            'totalClasses',
            'totalBootcamps',
            'totalHours', 
            'monthlyEarnings', 
            'recentClasses',
            'recentEnrollments',
            'recentStudents'
        ));
    }
    
    // Classes CRUD for Tutors
    public function classes()
    {
        $tutorId = session('user_id');
        $classes = Classes::where('tutor_id', $tutorId)
            ->withCount('payments')
            ->latest()
            ->paginate(10);
        
        return view('tutor.classes.index', compact('classes'));
    }
    
    public function classesCreate()
    {
        return view('tutor.classes.create');
    }
    
    public function classesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
        ]);

        Classes::create(array_merge($request->all(), [
            'tutor_id' => session('user_id'),
            'status' => 'active'
        ]));

        return redirect()->route('tutor.classes')->with('success', 'Class created successfully!');
    }
    
    public function classesEdit($id)
    {
        $class = Classes::where('tutor_id', session('user_id'))->findOrFail($id);
        return view('tutor.classes.edit', compact('class'));
    }
    
    public function classesUpdate(Request $request, $id)
    {
        $class = Classes::where('tutor_id', session('user_id'))->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'status' => 'required|in:active,inactive,completed'
        ]);

        $class->update($request->all());

        return redirect()->route('tutor.classes')->with('success', 'Class updated successfully!');
    }
    
    public function classesDestroy($id)
    {
        $class = Classes::where('tutor_id', session('user_id'))->findOrFail($id);
        $class->delete();

        return redirect()->route('tutor.classes')->with('success', 'Class deleted successfully!');
    }
    
    // Tasks CRUD for Tutors
    public function tasks()
    {
        $tutorId = session('user_id');
        $tasks = Task::with(['class'])
            ->where('assigned_by', $tutorId)
            ->orWhereHas('class', function($query) use ($tutorId) {
                $query->where('tutor_id', $tutorId);
            })
            ->latest()
            ->paginate(10);
        
        return view('tutor.tasks.index', compact('tasks'));
    }
    
    public function tasksCreate()
    {
        $tutorId = session('user_id');
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        return view('tutor.tasks.create', compact('classes'));
    }
    
    public function tasksStore(Request $request)
    {
        // Debug logging
        Log::info('Tasks store method called', [
            'request_data' => $request->all(),
            'session_data' => [
                'user_id' => session('user_id'),
                'role' => session('role'),
                'username' => session('username')
            ]
        ]);
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'class_id' => 'required|exists:classes,id',
                'due_date' => 'required|date|after:now',
                'priority' => 'required|in:low,medium,high',
                'instructions' => 'nullable|string',
            ]);
            
            // Verify the class belongs to this tutor
            $class = Classes::where('id', $request->class_id)
                ->where('tutor_id', session('user_id'))
                ->firstOrFail();

            $task = Task::create(array_merge($request->all(), [
                'assigned_by' => session('user_id'),
                'status' => 'pending'
            ]));
            
            Log::info('Task created successfully', ['task_id' => $task->id]);

            return redirect()->route('tutor.tasks')->with('success', 'Task created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed in tasksStore', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Exception in tasksStore', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'An error occurred while creating the task: ' . $e->getMessage());
        }
    }
    
    public function tasksEdit($id)
    {
        $tutorId = session('user_id');
        $task = Task::with('class')
            ->where(function($query) use ($tutorId) {
                $query->where('assigned_by', $tutorId)
                      ->orWhereHas('class', function($q) use ($tutorId) {
                          $q->where('tutor_id', $tutorId);
                      });
            })
            ->findOrFail($id);
            
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        
        return view('tutor.tasks.edit', compact('task', 'classes'));
    }
    
    public function tasksUpdate(Request $request, $id)
    {
        $tutorId = session('user_id');
        $task = Task::with('class')
            ->where(function($query) use ($tutorId) {
                $query->where('assigned_by', $tutorId)
                      ->orWhereHas('class', function($q) use ($tutorId) {
                          $q->where('tutor_id', $tutorId);
                      });
            })
            ->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'instructions' => 'nullable|string',
        ]);
        
        // Verify the new class belongs to this tutor
        $class = Classes::where('id', $request->class_id)
            ->where('tutor_id', session('user_id'))
            ->firstOrFail();

        $task->update($request->all());

        return redirect()->route('tutor.tasks')->with('success', 'Task updated successfully!');
    }
    
    public function tasksDestroy($id)
    {
        $tutorId = session('user_id');
        $task = Task::where(function($query) use ($tutorId) {
            $query->where('assigned_by', $tutorId)
                  ->orWhereHas('class', function($q) use ($tutorId) {
                      $q->where('tutor_id', $tutorId);
                  });
        })->findOrFail($id);
        
        $task->delete();

        return redirect()->route('tutor.tasks')->with('success', 'Task deleted successfully!');
    }
    
    // Grades CRUD for Tutors
    public function grades()
    {
        $tutorId = session('user_id');
        $grades = Grade::with(['student', 'class', 'task'])
            ->where('graded_by', $tutorId)
            ->orWhereHas('class', function($query) use ($tutorId) {
                $query->where('tutor_id', $tutorId);
            })
            ->latest()
            ->paginate(10);
        
        return view('tutor.grades.index', compact('grades'));
    }
    
    public function gradesCreate()
    {
        $tutorId = session('user_id');
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        $students = User::where('role', 'member')->get();
        $tasks = Task::whereHas('class', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })->get();
        
        return view('tutor.grades.create', compact('classes', 'students', 'tasks'));
    }
    
    public function gradesStore(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'task_id' => 'nullable|exists:tasks,id',
            'score' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:assignment,quiz,exam,project,participation',
            'feedback' => 'nullable|string',
        ]);
        
        // Verify the class belongs to this tutor
        $class = Classes::where('id', $request->class_id)
            ->where('tutor_id', session('user_id'))
            ->firstOrFail();
        
        // Calculate letter grade
        $score = $request->score;
        $letterGrade = 'F';
        if ($score >= 90) $letterGrade = 'A';
        elseif ($score >= 80) $letterGrade = 'B';
        elseif ($score >= 70) $letterGrade = 'C';
        elseif ($score >= 60) $letterGrade = 'D';

        Grade::create(array_merge($request->all(), [
            'graded_by' => session('user_id'),
            'grade' => $letterGrade
        ]));

        return redirect()->route('tutor.grades')->with('success', 'Grade added successfully!');
    }
    
    public function gradesEdit($id)
    {
        $tutorId = session('user_id');
        $grade = Grade::with(['student', 'class', 'task'])
            ->where(function($query) use ($tutorId) {
                $query->where('graded_by', $tutorId)
                      ->orWhereHas('class', function($q) use ($tutorId) {
                          $q->where('tutor_id', $tutorId);
                      });
            })
            ->findOrFail($id);
            
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        $students = User::where('role', 'member')->get();
        $tasks = Task::whereHas('class', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })->get();
        
        return view('tutor.grades.edit', compact('grade', 'classes', 'students', 'tasks'));
    }
    
    public function gradesUpdate(Request $request, $id)
    {
        $tutorId = session('user_id');
        $grade = Grade::where(function($query) use ($tutorId) {
            $query->where('graded_by', $tutorId)
                  ->orWhereHas('class', function($q) use ($tutorId) {
                      $q->where('tutor_id', $tutorId);
                  });
        })->findOrFail($id);
        
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'task_id' => 'nullable|exists:tasks,id',
            'score' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:assignment,quiz,exam,project,participation',
            'feedback' => 'nullable|string',
        ]);
        
        // Verify the new class belongs to this tutor
        $class = Classes::where('id', $request->class_id)
            ->where('tutor_id', session('user_id'))
            ->firstOrFail();
        
        // Calculate letter grade
        $score = $request->score;
        $letterGrade = 'F';
        if ($score >= 90) $letterGrade = 'A';
        elseif ($score >= 80) $letterGrade = 'B';
        elseif ($score >= 70) $letterGrade = 'C';
        elseif ($score >= 60) $letterGrade = 'D';

        $grade->update(array_merge($request->except(['graded_by']), [
            'grade' => $letterGrade
        ]));

        return redirect()->route('tutor.grades')->with('success', 'Grade updated successfully!');
    }
    
    public function gradesDestroy($id)
    {
        $tutorId = session('user_id');
        $grade = Grade::where(function($query) use ($tutorId) {
            $query->where('graded_by', $tutorId)
                  ->orWhereHas('class', function($q) use ($tutorId) {
                      $q->where('tutor_id', $tutorId);
                  });
        })->findOrFail($id);
        
        $grade->delete();

        return redirect()->route('tutor.grades')->with('success', 'Grade deleted successfully!');
    }
    
    public function account()
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get tutor user from database
        $tutor = User::find($userId);
        
        if (!$tutor || $tutor->role !== 'tutor') {
            return redirect()->route('auth')->with('error', 'Access denied. Tutor privileges required.');
        }
        
        // Get tutor statistics for account page
        $totalClasses = Classes::where('tutor_id', $userId)->count();
        $totalStudents = Payment::whereHas('class', function($query) use ($userId) {
            $query->where('tutor_id', $userId);
        })->where('status', 'completed')->distinct('user_id')->count();
        $totalEarnings = Payment::whereHas('class', function($query) use ($userId) {
            $query->where('tutor_id', $userId);
        })->where('status', 'completed')->sum('amount');
        
        return view('tutor.account', compact('tutor', 'totalClasses', 'totalStudents', 'totalEarnings'));
    }

    public function accountEdit()
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        // Get tutor user from database
        $tutor = User::find($userId);
        
        if (!$tutor || $tutor->role !== 'tutor') {
            return redirect()->route('auth')->with('error', 'Access denied. Tutor privileges required.');
        }
        
        return view('tutor.account-edit', compact('tutor'));
    }

    public function accountUpdate(Request $request)
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        $tutor = User::find($userId);
        
        if (!$tutor || $tutor->role !== 'tutor') {
            return redirect()->route('auth')->with('error', 'Access denied. Tutor privileges required.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($tutor->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($tutor->id)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($tutor->profile_photo && file_exists(public_path('storage/profile_photos/' . $tutor->profile_photo))) {
                unlink(public_path('storage/profile_photos/' . $tutor->profile_photo));
            }
            
            // Store new photo
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $tutor->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/profile_photos'), $filename);
            $updateData['profile_photo'] = $filename;
        }

        $tutor->update($updateData);
        
        // Update session data with new username
        session(['username' => $request->name]);

        return redirect()->route('tutor.account')->with('success', 'Profile updated successfully!');
    }

    public function accountPasswordUpdate(Request $request)
    {
        // Get user data from session (session-based auth)
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Session expired. Please login again.');
        }
        
        $tutor = User::find($userId);
        
        if (!$tutor || $tutor->role !== 'tutor') {
            return redirect()->route('auth')->with('error', 'Access denied. Tutor privileges required.');
        }
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $tutor->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $tutor->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('tutor.account')->with('success', 'Password updated successfully!');
    }

    // Video Contents CRUD for Tutors
    public function videoContents()
    {
        $tutorId = session('user_id');
        $videos = VideoContent::with(['class', 'bootcamp'])
            ->where('created_by', $tutorId)
            ->latest()
            ->paginate(10);
        
        return view('tutor.video-contents.index', compact('videos'));
    }
    
    public function videoContentsCreate()
    {
        $tutorId = session('user_id');
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        $bootcamps = Bootcamp::where('tutor_id', $tutorId)->get();
        
        return view('tutor.video-contents.create', compact('classes', 'bootcamps'));
    }
    
    public function videoContentsStore(Request $request)
    {
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
        $data['created_by'] = session('user_id');

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('video-thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        VideoContent::create($data);

        return redirect()->route('tutor.video-contents')->with('success', 'Video content created successfully.');
    }
    
    public function videoContentsEdit($id)
    {
        $tutorId = session('user_id');
        $video = VideoContent::where('created_by', $tutorId)->findOrFail($id);
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        $bootcamps = Bootcamp::where('tutor_id', $tutorId)->get();
        
        return view('tutor.video-contents.edit', compact('video', 'classes', 'bootcamps'));
    }
    
    public function videoContentsUpdate(Request $request, $id)
    {
        $tutorId = session('user_id');
        $video = VideoContent::where('created_by', $tutorId)->findOrFail($id);
        
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

        $data = $request->except(['thumbnail']);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('video-thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $video->update($data);

        return redirect()->route('tutor.video-contents')->with('success', 'Video content updated successfully.');
    }
    
    public function videoContentsDestroy($id)
    {
        $tutorId = session('user_id');
        $video = VideoContent::where('created_by', $tutorId)->findOrFail($id);
        
        // Delete thumbnail if exists
        if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        
        $video->delete();

        return redirect()->route('tutor.video-contents')->with('success', 'Video content deleted successfully.');
    }
}
