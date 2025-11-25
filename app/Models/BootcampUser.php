<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BootcampUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bootcamp_id',
        'status',
        'enrolled_date',
        'completion_date',
        'progress_percentage',
        'completed_tasks',
        'total_tasks',
        'average_score',
        'task_scores',
        'certificate_eligible',
        'certificate_issued',
        'notes'
    ];

    protected $casts = [
        'enrolled_date' => 'date',
        'completion_date' => 'date',
        'progress_percentage' => 'decimal:2',
        'average_score' => 'decimal:2',
        'task_scores' => 'array',
        'certificate_eligible' => 'boolean',
        'certificate_issued' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'user_id', 'user_id')
                    ->where('bootcamp_id', $this->bootcamp_id);
    }

    public function taskSubmissions()
    {
        return $this->hasManyThrough(
            TaskSubmission::class,
            Task::class,
            'bootcamp_id', // Foreign key on tasks table
            'task_id',     // Foreign key on task_submissions table
            'bootcamp_id', // Local key on bootcamp_users table
            'id'           // Local key on tasks table
        )->where('task_submissions.user_id', $this->user_id);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCertificateEligible($query)
    {
        return $query->where('certificate_eligible', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByBootcamp($query, $bootcampId)
    {
        return $query->where('bootcamp_id', $bootcampId);
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    public function getProgressPercentageFormattedAttribute()
    {
        return number_format($this->progress_percentage, 1) . '%';
    }

    public function getCompletionRatioAttribute()
    {
        if ($this->total_tasks == 0) return '0/0';
        return $this->completed_tasks . '/' . $this->total_tasks;
    }

    // Methods
    public function updateProgress()
    {
        $bootcampTasks = Task::where('bootcamp_id', $this->bootcamp_id)->count();
        $passedSubmissions = TaskSubmission::whereHas('task', function($query) {
                return $query->where('bootcamp_id', $this->bootcamp_id);
            })
            ->where('user_id', $this->user_id)
            ->where('submission_status', 'passed')
            ->count();

        $this->update([
            'total_tasks' => $bootcampTasks,
            'completed_tasks' => $passedSubmissions,
            'progress_percentage' => $bootcampTasks > 0 ? ($passedSubmissions / $bootcampTasks) * 100 : 0
        ]);

        // Check certificate eligibility
        $this->checkCertificateEligibility();
    }

    public function checkCertificateEligibility()
    {
        $allTasksPassed = $this->completed_tasks == $this->total_tasks && $this->total_tasks > 0;
        $minimumScore = $this->average_score >= 70; // Minimum 70% average

        $eligible = $allTasksPassed && $minimumScore;

        $this->update([
            'certificate_eligible' => $eligible,
            'status' => $eligible ? 'completed' : 'active',
            'completion_date' => $eligible ? now()->toDateString() : null
        ]);

        // Auto-generate certificate if eligible and not issued yet
        if ($eligible && !$this->certificate_issued) {
            $this->generateCertificate();
        }
    }

    public function calculateAverageScore()
    {
        $submissions = TaskSubmission::whereHas('task', function($query) {
                return $query->where('bootcamp_id', $this->bootcamp_id);
            })
            ->where('user_id', $this->user_id)
            ->where('submission_status', 'passed')
            ->whereNotNull('grade')
            ->get();

        if ($submissions->isEmpty()) {
            return 0;
        }

        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($submissions as $submission) {
            $taskWeight = $submission->task->weight ?? 1;
            $totalWeightedScore += $submission->grade * $taskWeight;
            $totalWeight += $taskWeight;
        }

        $averageScore = $totalWeight > 0 ? $totalWeightedScore / $totalWeight : 0;

        $this->update([
            'average_score' => $averageScore,
            'task_scores' => $submissions->pluck('grade', 'task_id')->toArray()
        ]);

        return $averageScore;
    }

    public function generateCertificate()
    {
        if ($this->certificate_issued) {
            return $this->certificate;
        }

        $certificate = Certificate::create([
            'user_id' => $this->user_id,
            'bootcamp_id' => $this->bootcamp_id,
            'student_name' => $this->user->name,
            'bootcamp_title' => $this->bootcamp->title,
            'instructor_name' => $this->bootcamp->tutor->name,
            'completion_date' => $this->completion_date,
            'total_tasks' => $this->total_tasks,
            'completed_tasks' => $this->completed_tasks,
            'final_score' => $this->average_score,
            'metadata' => [
                'task_scores' => $this->task_scores,
                'bootcamp_duration' => $this->bootcamp->duration,
                'generated_at' => now()->toISOString()
            ]
        ]);

        $this->update(['certificate_issued' => true]);

        return $certificate;
    }
}