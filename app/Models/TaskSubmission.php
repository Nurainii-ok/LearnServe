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
        'graded_by'
    ];

    protected $casts = [
        'graded_at' => 'datetime',
        'grade' => 'integer'
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

    // Scopes
    public function scopeGraded($query)
    {
        return $query->whereNotNull('grade');
    }

    public function scopeUngraded($query)
    {
        return $query->whereNull('grade');
    }

    public function scopeByTask($query, $taskId)
    {
        return $query->where('task_id', $taskId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function isGraded()
    {
        return !is_null($this->grade);
    }

    public function hasFile()
    {
        return !is_null($this->file_path);
    }

    public function getFileUrl()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getGradePercentage()
    {
        return $this->grade ? $this->grade . '%' : 'Not Graded';
    }

    public function getGradeLetter()
    {
        if (!$this->grade) return 'N/A';
        
        if ($this->grade >= 90) return 'A';
        if ($this->grade >= 80) return 'B';
        if ($this->grade >= 70) return 'C';
        if ($this->grade >= 60) return 'D';
        return 'F';
    }
}
