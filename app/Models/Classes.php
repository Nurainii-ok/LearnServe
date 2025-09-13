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
        'capacity',
        'enrolled',
        'price',
        'start_date',
        'end_date',
        'schedule',
        'status',
        'category'
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

    public function tasks()
    {
        return $this->hasMany(Task::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'class_id');
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
