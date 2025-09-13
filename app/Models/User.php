<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    // Relationships
    public function classesAsTeacher()
    {
        return $this->hasMany(Classes::class, 'tutor_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    // Scopes
    public function scopeTutors($query)
    {
        return $query->where('role', 'tutor');
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}
