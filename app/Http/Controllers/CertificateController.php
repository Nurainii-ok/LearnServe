<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    // Tutor can issue certificate for completed task
    public function issueTaskCertificate(Request $request, TaskSubmission $submission)
    {
        $user = Auth::user();
        
        // Ensure tutor can only issue certificates for their own tasks
        if ($submission->task->assigned_by !== $user->id) {
            abort(403);
        }
        
        // Ensure submission is graded and passed
        if (!$submission->is_graded || $submission->grade < 70) {
            return redirect()->back()->with('error', 'Certificate can only be issued for graded submissions with grade ≥ 70.');
        }
        
        // Check if certificate already exists
        $existingCert = Certificate::where('user_id', $submission->user_id)
                                 ->where('task_id', $submission->task_id)
                                 ->where('type', 'task')
                                 ->first();
        
        if ($existingCert) {
            return redirect()->back()->with('error', 'Certificate already issued for this task.');
        }
        
        // Create certificate
        $certificate = Certificate::create([
            'user_id' => $submission->user_id,
            'task_id' => $submission->task_id,
            'class_id' => $submission->task->class_id,
            'type' => 'task',
            'title' => 'Task Completion Certificate',
            'description' => "Certificate of completion for task: {$submission->task->title}",
            'final_score' => $submission->grade,
            'completion_date' => now()->toDateString(),
            'issued_by' => $user->id,
            'status' => 'active',
            'metadata' => [
                'task_title' => $submission->task->title,
                'class_title' => $submission->task->class->title,
                'submission_date' => $submission->created_at->toDateString(),
                'grade_date' => $submission->graded_at->toDateString()
            ]
        ]);
        
        return redirect()->back()->with('success', 'Certificate issued successfully!');
    }
    
    // Member can view their certificates
    public function memberIndex()
    {
        $user = Auth::user();
        
        $certificates = Certificate::where('user_id', $user->id)
                                 ->with(['task', 'class', 'bootcamp', 'issuedBy'])
                                 ->orderBy('completion_date', 'desc')
                                 ->paginate(10);
        
        return view('member.certificates.index', compact('certificates'));
    }
    
    // Admin can view all certificates
    public function adminIndex()
{
    // Statistik berdasarkan struktur tabel kamu
    $totalCertificates = Certificate::count(); // Semua sertifikat
    $uniqueStudents = Certificate::distinct('user_id')->count('user_id'); // Murid unik
    $uniqueBootcamps = Certificate::distinct('bootcamp_id')->count('bootcamp_id'); // Bootcamp unik

    // Daftar sertifikat untuk tabel
    $certificates = Certificate::with(['user', 'bootcamp'])
        ->latest()
        ->paginate(15);

    return view('admin.certificates.index', compact(
        'totalCertificates',
        'uniqueStudents',
        'uniqueBootcamps',
        'certificates'
    ));
}

    
    // Public certificate verification
    public function verify($certificateId)
    {
        $certificate = Certificate::where('certificate_id', $certificateId)
                                ->where('status', 'active')
                                ->with(['user', 'bootcamp'])
                                ->first();
        
        if (!$certificate) {
            return view('certificates.verify-invalid');
        }
        
        return view('certificates.verify', compact('certificate'));
    }
}
