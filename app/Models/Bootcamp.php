<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SequentialId;

class Bootcamp extends Model
{
    use SequentialId;
    protected $table = 'bootcamps';

    protected $fillable = [
        'title',
        'description',
        'tutor_id',
        'capacity',
        'enrolled',
        'price',
        'start_date',
        'end_date',
        'duration',
        'status',
        'category',
        'image',
        'level',
        'requirements'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    // Relationships
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'bootcamp_id');
    }

    public function activeEnrollments()
    {
        return $this->hasMany(Enrollment::class, 'bootcamp_id')->where('status', 'active');
    }

    public function enrolledStudents()
    {
        return $this->hasManyThrough(User::class, Enrollment::class, 'bootcamp_id', 'id', 'id', 'user_id')
                    ->where('enrollments.status', 'active');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'bootcamp_id');
    }

    public function videoContents()
    {
        return $this->hasMany(VideoContent::class, 'bootcamp_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'bootcamp_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function students()
    {
        return $this->hasManyThrough(User::class, Enrollment::class, 'bootcamp_id', 'id', 'id', 'user_id')
                    ->where('enrollments.status', 'active');
    }

    public function bootcampUsers()
    {
        return $this->hasMany(BootcampUser::class, 'bootcamp_id');
    }

    public function activeBootcampUsers()
    {
        return $this->hasMany(BootcampUser::class, 'bootcamp_id')->where('status', 'active');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'bootcamp_id');
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
