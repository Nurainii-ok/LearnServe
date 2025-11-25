<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Bootcamp;
use App\Models\BootcampUser;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BootcampTaskController extends Controller
{
    // Middleware will be applied in individual methods

    // MEMBER METHODS - Dashboard Bootcamp Tasks
    public function memberIndex()
    {
        
        $user = Auth::user();
        
        // Get user's enrolled bootcamps
        $enrolledBootcamps = BootcampUser::with(['bootcamp', 'certificate'])
                                       ->where('user_id', $user->id)
                                       ->where('status', 'active')
                                       ->get();

        return view('member.bootcamp-tasks.index', compact('enrolledBootcamps'));
    }

    public function memberBootcampTasks($bootcampId)
    {
        
        $user = Auth::user();
        
        // Verify user is enrolled in this bootcamp
        $bootcampUser = BootcampUser::where('user_id', $user->id)
                                   ->where('bootcamp_id', $bootcampId)
                                   ->firstOrFail();

        $bootcamp = Bootcamp::with('tutor')->findOrFail($bootcampId);
        
        // Get all tasks for this bootcamp with user's submissions
        $tasks = Task::with(['submissions' => function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    }])
                    ->where('bootcamp_id', $bootcampId)
                    ->ordered()
                    ->get();

        return view('member.bootcamp-tasks.tasks', compact('bootcamp', 'tasks', 'bootcampUser'));
    }

    public function memberTaskDetail($bootcampId, $taskId)
    {
        
        $user = Auth::user();
        
        // Verify enrollment
        $bootcampUser = BootcampUser::where('user_id', $user->id)
                                   ->where('bootcamp_id', $bootcampId)
                                   ->firstOrFail();

        $task = Task::where('id', $taskId)
                   ->where('bootcamp_id', $bootcampId)
                   ->firstOrFail();

        $submission = TaskSubmission::where('task_id', $taskId)
                                   ->where('user_id', $user->id)
                                   ->first();

        return view('member.bootcamp-tasks.task-detail', compact('task', 'submission', 'bootcampUser'));
    }

    public function memberSubmitTask(Request $request, $bootcampId, $taskId)
    {
        
        $user = Auth::user();
        
        // Verify enrollment
        BootcampUser::where('user_id', $user->id)
                   ->where('bootcamp_id', $bootcampId)
                   ->firstOrFail();

        $task = Task::where('id', $taskId)
                   ->where('bootcamp_id', $bootcampId)
                   ->firstOrFail();

        $request->validate([
            'content' => 'nullable|string',
            'submission_url' => 'nullable|url',
            'submission_notes' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Handle file upload
        $filePath = null;
        $originalFilename = null;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('bootcamp-submissions', 'public');
            $originalFilename = $file->getClientOriginalName();
        }

        // Check if submission exists
        $submission = TaskSubmission::where('task_id', $taskId)
                                   ->where('user_id', $user->id)
                                   ->first();

        if ($submission) {
            // Resubmission
            if ($submission->can_resubmit) {
                // Delete old file if new file uploaded
                if ($filePath && $submission->file_path) {
                    Storage::disk('public')->delete($submission->file_path);
                }
                
                $submission->resubmit(
                    $request->content,
                    $filePath ?: $submission->file_path,
                    $request->submission_url,
                    $request->submission_notes
                );
                
                $message = 'Task resubmitted successfully!';
            } else {
                return redirect()->back()->with('error', 'Cannot resubmit this task.');
            }
        } else {
            // New submission
            TaskSubmission::create([
                'task_id' => $taskId,
                'user_id' => $user->id,
                'content' => $request->content,
                'file_path' => $filePath,
                'original_filename' => $originalFilename,
                'submission_url' => $request->submission_url,
                'submission_notes' => $request->submission_notes,
                'submission_status' => 'pending'
            ]);
            
            $message = 'Task submitted successfully!';
        }

        return redirect()->route('member.bootcamp-tasks.tasks', $bootcampId)
                        ->with('success', $message);
    }

    // TUTOR/MENTOR METHODS - Review Tasks
    public function tutorIndex()
    {
        
        $user = Auth::user();
        
        // Get tutor's bootcamps with pending submissions
        $bootcamps = Bootcamp::with(['tasks.submissions' => function($query) {
                                $query->whereIn('submission_status', ['pending', 'under_review']);
                            }])
                            ->where('tutor_id', $user->id)
                            ->get();

        return view('tutor.bootcamp-tasks.index', compact('bootcamps'));
    }

    public function tutorBootcampTasks($bootcampId)
    {
        
        $user = Auth::user();
        
        $bootcamp = Bootcamp::where('id', $bootcampId)
                           ->where('tutor_id', $user->id)
                           ->firstOrFail();

        // Get all submissions for this bootcamp
        $submissions = TaskSubmission::with(['task', 'user'])
                                    ->whereHas('task', function($query) use ($bootcampId) {
                                        $query->where('bootcamp_id', $bootcampId);
                                    })
                                    ->latest()
                                    ->paginate(20);

        return view('tutor.bootcamp-tasks.submissions', compact('bootcamp', 'submissions'));
    }

    public function tutorReviewSubmission($submissionId)
    {
        
        $user = Auth::user();
        
        $submission = TaskSubmission::with(['task.bootcamp', 'user'])
                                   ->whereHas('task.bootcamp', function($query) use ($user) {
                                       $query->where('tutor_id', $user->id);
                                   })
                                   ->findOrFail($submissionId);

        return view('tutor.bootcamp-tasks.review', compact('submission'));
    }

    public function tutorSubmitReview(Request $request, $submissionId)
    {
        
        $user = Auth::user();
        
        $submission = TaskSubmission::with(['task.bootcamp'])
                                   ->whereHas('task.bootcamp', function($query) use ($user) {
                                       $query->where('tutor_id', $user->id);
                                   })
                                   ->findOrFail($submissionId);

        $request->validate([
            'action' => 'required|in:pass,revision,fail',
            'grade' => 'nullable|integer|min:0|max:100',
            'feedback' => 'required|string|min:10'
        ]);

        switch ($request->action) {
            case 'pass':
                $submission->markAsPassed($user->id, $request->grade, $request->feedback);
                $message = 'Task marked as passed!';
                
                // Auto-generate certificate if all bootcamp tasks are completed
                $certificateService = new \App\Services\CertificateService();
                $certificate = $certificateService->autoGenerateAfterTaskCompletion(
                    $submission->user_id, 
                    $submission->task->bootcamp_id
                );
                
                if ($certificate) {
                    $message .= ' Certificate has been automatically generated for the student!';
                }
                break;
                
            case 'revision':
                $submission->markAsRevision($user->id, $request->feedback);
                $message = 'Task marked for revision!';
                break;
                
            case 'fail':
                $submission->markAsFailed($user->id, $request->feedback);
                $message = 'Task marked as failed!';
                break;
        }

        return redirect()->route('tutor.bootcamp-tasks.submissions', $submission->task->bootcamp_id)
                        ->with('success', $message);
    }

    // ADMIN METHODS - Overview
    public function adminIndex()
    {
        
        $bootcamps = Bootcamp::with(['tasks', 'enrolledStudents'])
                            ->withCount(['tasks', 'enrolledStudents'])
                            ->get();

        $totalSubmissions = TaskSubmission::whereHas('task', function($query) {
            $query->whereNotNull('bootcamp_id');
        })->count();

        $pendingReviews = TaskSubmission::whereHas('task', function($query) {
            $query->whereNotNull('bootcamp_id');
        })->where('submission_status', 'pending')->count();

        $certificates = Certificate::count();

        return view('admin.bootcamp-tasks.index', compact('bootcamps', 'totalSubmissions', 'pendingReviews', 'certificates'));
    }

    // CERTIFICATE METHODS
    public function memberCertificates()
    {
        
        $user = Auth::user();
        
        $certificates = Certificate::with('bootcamp')
                                  ->where('user_id', $user->id)
                                  ->where('status', 'active')
                                  ->latest()
                                  ->get();

        return view('member.certificates.index', compact('certificates'));
    }

    public function verifyCertificate($code)
    {
        $certificate = Certificate::where('certificate_code', $code)
                                 ->where('status', 'active')
                                 ->firstOrFail();

        return view('certificates.verify', compact('certificate'));
    }

    public function downloadCertificate($certificateId)
    {
        
        $user = Auth::user();
        
        $certificate = Certificate::where('id', $certificateId)
                                 ->where('user_id', $user->id)
                                 ->where('status', 'active')
                                 ->firstOrFail();

        // Generate PDF certificate if not exists
        if (!$certificate->certificate_file) {
            $this->generateCertificatePDF($certificate);
        }

        return response()->download(storage_path('app/public/certificates/' . $certificate->certificate_file));
    }

    private function generateCertificatePDF($certificate)
    {
        $certificateService = new \App\Services\CertificateService();
        return $certificateService->generatePDF($certificate);
    }
}