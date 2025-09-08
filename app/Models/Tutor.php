<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    /** @use HasFactory<\Database\Factories\TutorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'expertise', // ganti mapel jadi expertise
        'role',
    ];
}


