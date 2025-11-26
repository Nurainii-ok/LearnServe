<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Bootcamp;
use App\Models\User;
use App\Models\BootcampTask;
use App\Models\BootcampTaskSubmission;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateService
{
    /**
     * Check if user has completed all bootcamp tasks
     */
    public function checkBootcampCompletion($userId, $bootcampId)
    {
        // Get total tasks in bootcamp
        $totalTasks = Task::where('bootcamp_id', $bootcampId)->count();
        
        // Get completed tasks by user (status = 'passed')
        $completedTasks = TaskSubmission::whereHas('bootcampTask', function($query) use ($bootcampId) {
            $query->where('bootcamp_id', $bootcampId);
        })
        ->where('user_id', $userId)
        ->where('status', 'passed')
        ->count();
        
        return $totalTasks > 0 && $totalTasks === $completedTasks;
    }
    
    /**
     * Generate certificate for completed bootcamp
     */
    public function generateCertificate($userId, $bootcampId)
    {
        // Check if certificate already exists
        $existingCert = Certificate::where('user_id', $userId)
                                 ->where('bootcamp_id', $bootcampId)
                                 ->first();
        
        if ($existingCert) {
            return $existingCert;
        }
        
        // Check if bootcamp is completed
        if (!$this->checkBootcampCompletion($userId, $bootcampId)) {
            throw new \Exception('Bootcamp not completed yet');
        }
        
        $user = User::findOrFail($userId);
        $bootcamp = Bootcamp::findOrFail($bootcampId);
        
        // Create certificate record
        $certificate = Certificate::create([
            'user_id' => $userId,
            'bootcamp_id' => $bootcampId,
            'status' => 'active',
            'metadata' => [
                'student_name' => $user->name,
                'bootcamp_title' => $bootcamp->title,
                'instructor_name' => $bootcamp->tutor->name ?? 'LearnServe Team',
                'completion_date' => now()->format('Y-m-d'),
                'total_tasks' => Task::where('bootcamp_id', $bootcampId)->count()
            ]
        ]);
        
        // Generate QR Code
        $qrCodePath = $this->generateQrCode($certificate);
        
        // Generate PDF
        $pdfPath = $this->generatePdf($certificate);
        
        // Update certificate with file paths
        $certificate->update([
            'qr_code_path' => $qrCodePath,
            'pdf_path' => $pdfPath
        ]);
        
        return $certificate;
    }
    
    /**
     * Generate QR Code for certificate verification
     */
    private function generateQrCode($certificate)
    {
        $verificationUrl = route('certificate.verify', $certificate->certificate_id);
        
        $qrCode = QrCode::format('png')
                       ->size(200)
                       ->margin(2)
                       ->generate($verificationUrl);
        
        $fileName = 'qr_' . $certificate->certificate_id . '.png';
        $path = 'certificates/qr/' . $fileName;
        
        Storage::disk('public')->put($path, $qrCode);
        
        return $path;
    }
    
    /**
     * Generate PDF certificate
     */
    private function generatePdf($certificate)
    {
        $data = [
            'certificate' => $certificate,
            'student_name' => $certificate->metadata['student_name'],
            'bootcamp_title' => $certificate->metadata['bootcamp_title'],
            'instructor_name' => $certificate->metadata['instructor_name'],
            'completion_date' => $certificate->metadata['completion_date'],
            'certificate_id' => $certificate->certificate_id,
            'qr_code_url' => $certificate->qr_code_url,
            'verification_url' => $certificate->verification_url
        ];
        
        $pdf = Pdf::loadView('certificates.template', $data)
                  ->setPaper('a4', 'landscape')
                  ->setOptions([
                      'dpi' => 150,
                      'defaultFont' => 'sans-serif',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => true
                  ]);
        
        $fileName = 'cert_' . $certificate->certificate_id . '.pdf';
        $path = 'certificates/pdf/' . $fileName;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        return $path;
    }
    
    /**
     * Auto-check and generate certificate after task completion
     */
    public function autoGenerateAfterTaskCompletion($userId, $bootcampId)
    {
        try {
            if ($this->checkBootcampCompletion($userId, $bootcampId)) {
                return $this->generateCertificate($userId, $bootcampId);
            }
        } catch (\Exception $e) {
            \Log::error('Auto certificate generation failed: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Get completion progress for bootcamp
     */
    /*public function getBootcampProgress($userId, $bootcampId)
    {
        $totalTasks = Task::where('bootcamp_id', $bootcampId)->count();
        
        $completedTasks = TaskSubmission::whereHas('Task', function($query) use ($bootcampId) {
            $query->where('bootcamp_id', $bootcampId);
        })
        ->where('user_id', $userId)
        ->where('passed')
        ->count();

        
        $pendingTasks = TaskSubmission::whereHas('Task', function($query) use ($bootcampId) {
            $query->where('bootcamp_id', $bootcampId);
        })
        ->where('user_id', $userId)
        ->where('status', 'pending')
        ->count();
        
        $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        return [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'not_submitted' => $totalTasks - $completedTasks - $pendingTasks,
            'progress_percentage' => $progressPercentage,
            'is_completed' => $totalTasks > 0 && $totalTasks === $completedTasks
        ];
    }*/
}