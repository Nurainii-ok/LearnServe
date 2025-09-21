<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'title',
        'description',
        'tutor_id',
        'enrolled',
        'price',
        'status',
        'category',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relationships
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'class_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function activeEnrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id')->where('status', 'active');
    }

    public function enrolledStudents()
    {
        return $this->hasManyThrough(User::class, Enrollment::class, 'class_id', 'id', 'id', 'user_id')
                    ->where('enrollments.status', 'active');
    }

    public function videoContents()
    {
        return $this->hasMany(VideoContent::class, 'class_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByTutor($query, $tutorId)
    {
        return $query->where('tutor_id', $tutorId);
    }
}
