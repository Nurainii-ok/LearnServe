<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'content',
        'file_path',
        'original_filename',
        'grade',
        'feedback',
        'graded_at',
        'graded_by',
        'submission_status',
        'revision_count',
        'mentor_feedback',
        'reviewed_at',
        'reviewed_by',
        'submission_url',
        'submission_notes',
        'meets_minimum_score',
        'resubmitted_at',
        'revision_history'
    ];

    protected $casts = [
        'graded_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'resubmitted_at' => 'datetime',
        'revision_history' => 'array',
        'meets_minimum_score' => 'boolean'
    ];

    // Relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gradedBy()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Accessors
    public function getIsGradedAttribute()
    {
        return !is_null($this->grade);
    }

    public function getIsLateAttribute()
    {
        return $this->created_at > $this->task->due_date;
    }

    public function getGradeLetterAttribute()
    {
        if (is_null($this->grade)) {
            return 'Not Graded';
        }

        if ($this->grade >= 90) return 'A';
        if ($this->grade >= 80) return 'B';
        if ($this->grade >= 70) return 'C';
        if ($this->grade >= 60) return 'D';
        return 'F';
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getStatusDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->submission_status));
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->submission_status) {
            'pending' => 'bg-secondary',
            'under_review' => 'bg-info',
            'passed' => 'bg-success',
            'revision' => 'bg-warning',
            'failed' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    public function getIsPassedAttribute()
    {
        return $this->submission_status === 'passed';
    }

    public function getIsRevisionAttribute()
    {
        return $this->submission_status === 'revision';
    }

    public function getIsFailedAttribute()
    {
        return $this->submission_status === 'failed';
    }

    public function getCanResubmitAttribute()
    {
        return in_array($this->submission_status, ['revision', 'failed']);
    }

    public function getHasUrlSubmissionAttribute()
    {
        return !empty($this->submission_url);
    }

    public function getHasFileSubmissionAttribute()
    {
        return !empty($this->file_path);
    }

    // Methods for bootcamp workflow
    public function markAsPassed($mentorId, $grade = null, $feedback = null)
    {
        $this->update([
            'submission_status' => 'passed',
            'reviewed_by' => $mentorId,
            'reviewed_at' => now(),
            'grade' => $grade ?? $this->grade,
            'mentor_feedback' => $feedback,
            'meets_minimum_score' => ($grade ?? $this->grade) >= $this->task->min_score
        ]);

        // Update bootcamp user progress
        $this->updateBootcampProgress();
    }

    public function markAsRevision($mentorId, $feedback)
    {
        $revisionHistory = $this->revision_history ?? [];
        $revisionHistory[] = [
            'revision_number' => $this->revision_count + 1,
            'feedback' => $feedback,
            'reviewed_by' => $mentorId,
            'reviewed_at' => now()->toISOString(),
            'previous_status' => $this->submission_status
        ];

        $this->update([
            'submission_status' => 'revision',
            'reviewed_by' => $mentorId,
            'reviewed_at' => now(),
            'mentor_feedback' => $feedback,
            'revision_count' => $this->revision_count + 1,
            'revision_history' => $revisionHistory
        ]);
    }

    public function markAsFailed($mentorId, $feedback)
    {
        $this->update([
            'submission_status' => 'failed',
            'reviewed_by' => $mentorId,
            'reviewed_at' => now(),
            'mentor_feedback' => $feedback,
            'meets_minimum_score' => false
        ]);
    }

    public function resubmit($content = null, $filePath = null, $url = null, $notes = null)
    {
        $updateData = [
            'submission_status' => 'pending',
            'resubmitted_at' => now(),
            'reviewed_at' => null,
            'reviewed_by' => null
        ];

        if ($content !== null) $updateData['content'] = $content;
        if ($filePath !== null) $updateData['file_path'] = $filePath;
        if ($url !== null) $updateData['submission_url'] = $url;
        if ($notes !== null) $updateData['submission_notes'] = $notes;

        $this->update($updateData);
    }

    private function updateBootcampProgress()
    {
        if (!$this->task->bootcamp_id) return;

        $bootcampUser = \App\Models\BootcampUser::where('user_id', $this->user_id)
                                               ->where('bootcamp_id', $this->task->bootcamp_id)
                                               ->first();

        if ($bootcampUser) {
            $bootcampUser->updateProgress();
            $bootcampUser->calculateAverageScore();
        }
    }
}