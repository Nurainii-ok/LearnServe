<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'class_id',
        'bootcamp_id',
        'assigned_by',
        'due_date',
        'priority',
        'status',
        'instructions',
        'attachments',
        'task_order',
        'min_score',
        'task_type',
        'weight'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'attachments' => 'array',
        'weight' => 'decimal:2'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function course()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function bootcamp()
{
    return $this->belongsTo(Classes::class, 'class_id');
}


    // Scopes
    public function scopeForTutor($query, $tutorId)
    {
        return $query->where('assigned_by', $tutorId);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('status', '!=', 'completed');
    }

    public function scopeForBootcamp($query, $bootcampId)
    {
        return $query->where('bootcamp_id', $bootcampId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('task_order', 'asc');
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now() && $this->status !== 'completed';
    }

    public function getSubmissionCountAttribute()
    {
        return $this->submissions()->count();
    }

    public function getGradedCountAttribute()
    {
        return $this->submissions()->whereNotNull('grade')->count();
    }

    public function getPassedCountAttribute()
    {
        return $this->submissions()->where('submission_status', 'passed')->count();
    }

    public function getRevisionCountAttribute()
    {
        return $this->submissions()->where('submission_status', 'revision')->count();
    }

    public function getTaskTypeDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->task_type));
    }

    public function getIsBootcampTaskAttribute()
    {
        return !is_null($this->bootcamp_id);
    }

    public function getParentAttribute()
    {
        return $this->bootcamp_id ? $this->bootcamp : $this->class;
    }
}