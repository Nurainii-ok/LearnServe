<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'bootcamp_id',
        'type',
        'status',
        'enrolled_at',
        'completed_at',
        'progress',
        'notes'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Classes::class, 'class_id');
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

    public function scopeForClass($query)
    {
        return $query->where('type', 'class');
    }

    public function scopeForBootcamp($query)
    {
        return $query->where('type', 'bootcamp');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
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

    public function getProgressPercentageAttribute()
    {
        return min(100, max(0, $this->progress));
    }
}
