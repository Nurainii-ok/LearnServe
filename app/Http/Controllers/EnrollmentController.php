<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function enrollClass(Request $request, $classId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Please login to enroll.');
        }
        
        $class = Classes::findOrFail($classId);
        
        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $userId)
            ->where('class_id', $classId)
            ->where('type', 'class')
            ->first();
            
        if ($existingEnrollment) {
            return back()->with('info', 'You are already enrolled in this class.');
        }
        
        DB::beginTransaction();
        try {
            // Create enrollment
            $enrollment = Enrollment::create([
                'user_id' => $userId,
                'class_id' => $classId,
                'type' => 'class',
                'status' => 'active',
                'enrolled_at' => now(),
                'progress' => 0.00
            ]);
            
            // Update enrolled count in classes table
            $class->increment('enrolled');
            
            // Create payment record (assuming immediate enrollment for now)
            Payment::create([
                'user_id' => $userId,
                'class_id' => $classId,
                'amount' => $class->price,
                'payment_method' => 'direct_enrollment',
                'transaction_id' => 'ENR_' . time() . '_' . $userId,
                'status' => 'completed',
                'payment_date' => now(),
                'notes' => 'Direct enrollment from learning page'
            ]);
            
            DB::commit();
            
            return redirect()->route('member.enrollments')
                ->with('success', 'Successfully enrolled in ' . $class->title . '!');
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Enrollment failed', ['error' => $e->getMessage(), 'class_id' => $classId, 'user_id' => $userId]);
            return back()->with('error', 'Enrollment failed. Please try again.');
        }
    }
    
    public function enrollBootcamp(Request $request, $bootcampId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Please login to enroll.');
        }
        
        $bootcamp = Bootcamp::findOrFail($bootcampId);
        
        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $userId)
            ->where('bootcamp_id', $bootcampId)
            ->where('type', 'bootcamp')
            ->first();
            
        if ($existingEnrollment) {
            return back()->with('info', 'You are already enrolled in this bootcamp.');
        }
        
        DB::beginTransaction();
        try {
            // Create enrollment
            $enrollment = Enrollment::create([
                'user_id' => $userId,
                'bootcamp_id' => $bootcampId,
                'type' => 'bootcamp',
                'status' => 'active',
                'enrolled_at' => now(),
                'progress' => 0.00
            ]);
            
            // Update enrolled count in bootcamps table
            $bootcamp->increment('enrolled');
            
            DB::commit();
            
            return redirect()->route('member.enrollments')
                ->with('success', 'Successfully enrolled in ' . $bootcamp->title . '!');
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Bootcamp enrollment failed', ['error' => $e->getMessage(), 'bootcamp_id' => $bootcampId, 'user_id' => $userId]);
            return back()->with('error', 'Enrollment failed. Please try again.');
        }
    }
    
    public function unenroll(Request $request, $enrollmentId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Please login.');
        }
        
        $enrollment = Enrollment::where('id', $enrollmentId)
            ->where('user_id', $userId)
            ->firstOrFail();
            
        DB::beginTransaction();
        try {
            // Update enrollment status
            $enrollment->update(['status' => 'dropped']);
            
            // Decrement enrolled count
            if ($enrollment->type === 'class' && $enrollment->class) {
                $enrollment->class->decrement('enrolled');
            } elseif ($enrollment->type === 'bootcamp' && $enrollment->bootcamp) {
                $enrollment->bootcamp->decrement('enrolled');
            }
            
            DB::commit();
            
            return back()->with('success', 'Successfully unenrolled from the course.');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Unenrollment failed', ['error' => $e->getMessage(), 'enrollment_id' => $enrollmentId]);
            return back()->with('error', 'Unenrollment failed. Please try again.');
        }
    }
    
    public function updateProgress(Request $request, $enrollmentId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'progress' => 'required|numeric|min:0|max:100'
        ]);
        
        $enrollment = Enrollment::where('id', $enrollmentId)
            ->where('user_id', $userId)
            ->firstOrFail();
            
        $enrollment->update([
            'progress' => $request->progress,
            'completed_at' => $request->progress >= 100 ? now() : null,
            'status' => $request->progress >= 100 ? 'completed' : 'active'
        ]);
        
        return response()->json(['success' => true, 'message' => 'Progress updated successfully']);
    }
    
    // Admin methods
    public function adminIndex(Request $request)
    {
        $query = Enrollment::with(['user', 'class', 'bootcamp']);
        
        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Search by user name or email
        if ($request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $enrollments = $query->latest()->paginate(15);
        
        return view('admin.enrollments', compact('enrollments'));
    }
    
    public function adminDestroy($enrollmentId)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        
        DB::beginTransaction();
        try {
            // Decrement enrolled count
            if ($enrollment->type === 'class' && $enrollment->class) {
                $enrollment->class->decrement('enrolled');
            } elseif ($enrollment->type === 'bootcamp' && $enrollment->bootcamp) {
                $enrollment->bootcamp->decrement('enrolled');
            }
            
            $enrollment->delete();
            
            DB::commit();
            
            return back()->with('success', 'Enrollment deleted successfully.');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Admin enrollment deletion failed', ['error' => $e->getMessage(), 'enrollment_id' => $enrollmentId]);
            return back()->with('error', 'Deletion failed. Please try again.');
        }
    }
}
