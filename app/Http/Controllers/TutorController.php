<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;
use App\Models\Task;
use App\Models\Payment;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TutorController extends Controller
{
    public function dashboard()
    {
        $tutorId = Auth::id();
        
        // Get tutor dashboard statistics
        $totalStudents = Payment::whereHas('class', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })->where('status', 'completed')->distinct('user_id')->count();
        
        $totalClasses = Classes::where('tutor_id', $tutorId)->count();
        
        $totalHours = Classes::where('tutor_id', $tutorId)->count() * 40; // Estimate 40 hours per class
        
        $monthlyEarnings = Payment::whereHas('class', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })->where('status', 'completed')
          ->whereMonth('payment_date', now()->month)
          ->sum('amount');
        
        // Get recent classes
        $recentClasses = Classes::where('tutor_id', $tutorId)
            ->where('status', 'active')
            ->withCount('payments')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($class) {
                return [
                    'name' => $class->title,
                    'students' => $class->payments_count,
                    'next_session' => $class->start_date,
                ];
            });
        
        $recentStudents = User::whereHas('payments.class', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })->where('role', 'member')
            ->latest()
            ->take(5)
            ->get();
        
        return view('tutor.dashboard', compact(
            'totalStudents', 
            'totalClasses', 
            'totalHours', 
            'monthlyEarnings', 
            'recentClasses', 
            'recentStudents'
        ));
    }
    
    // Classes CRUD for Tutors
    public function classes()
    {
        $tutorId = Auth::id();
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
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'schedule' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        Classes::create(array_merge($request->all(), [
            'tutor_id' => Auth::id(),
            'status' => 'active'
        ]));

        return redirect()->route('tutor.classes')->with('success', 'Class created successfully!');
    }
    
    public function classesEdit($id)
    {
        $class = Classes::where('tutor_id', Auth::id())->findOrFail($id);
        return view('tutor.classes.edit', compact('class'));
    }
    
    public function classesUpdate(Request $request, $id)
    {
        $class = Classes::where('tutor_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'schedule' => 'nullable|string',
            'category' => 'nullable|string',
            'status' => 'required|in:active,inactive,completed'
        ]);

        $class->update($request->all());

        return redirect()->route('tutor.classes')->with('success', 'Class updated successfully!');
    }
    
    public function classesDestroy($id)
    {
        $class = Classes::where('tutor_id', Auth::id())->findOrFail($id);
        $class->delete();

        return redirect()->route('tutor.classes')->with('success', 'Class deleted successfully!');
    }
    
    // Tasks CRUD for Tutors
    public function tasks()
    {
        $tutorId = Auth::id();
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
        $tutorId = Auth::id();
        $classes = Classes::where('tutor_id', $tutorId)->where('status', 'active')->get();
        return view('tutor.tasks.create', compact('classes'));
    }
    
    public function tasksStore(Request $request)
    {
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
            ->where('tutor_id', Auth::id())
            ->firstOrFail();

        Task::create(array_merge($request->all(), [
            'assigned_by' => Auth::id(),
            'status' => 'pending'
        ]));

        return redirect()->route('tutor.tasks')->with('success', 'Task created successfully!');
    }
    
    public function tasksEdit($id)
    {
        $tutorId = Auth::id();
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
        $tutorId = Auth::id();
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
            ->where('tutor_id', Auth::id())
            ->firstOrFail();

        $task->update($request->all());

        return redirect()->route('tutor.tasks')->with('success', 'Task updated successfully!');
    }
    
    public function tasksDestroy($id)
    {
        $tutorId = Auth::id();
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
        $tutorId = Auth::id();
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
        $tutorId = Auth::id();
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
            ->where('tutor_id', Auth::id())
            ->firstOrFail();
        
        // Calculate letter grade
        $score = $request->score;
        $letterGrade = 'F';
        if ($score >= 90) $letterGrade = 'A';
        elseif ($score >= 80) $letterGrade = 'B';
        elseif ($score >= 70) $letterGrade = 'C';
        elseif ($score >= 60) $letterGrade = 'D';

        Grade::create(array_merge($request->all(), [
            'graded_by' => Auth::id(),
            'grade' => $letterGrade
        ]));

        return redirect()->route('tutor.grades')->with('success', 'Grade added successfully!');
    }
    
    public function gradesEdit($id)
    {
        $tutorId = Auth::id();
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
        $tutorId = Auth::id();
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
            ->where('tutor_id', Auth::id())
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
        $tutorId = Auth::id();
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
        return view('tutor.account');
    }
}
