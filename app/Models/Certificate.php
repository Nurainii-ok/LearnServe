<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bootcamp_id',
        'certificate_id',
        'certificate_number', // Keep for backward compatibility
        'pdf_path',
        'qr_code_path',
        'issued_at',
        'status',
        'metadata'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'metadata' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByBootcamp($query, $bootcampId)
    {
        return $query->where('bootcamp_id', $bootcampId);
    }

    // Accessors & Mutators
    public function getVerificationUrlAttribute()
    {
        return route('certificate.verify', $this->certificate_id);
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }

    public function getQrCodeUrlAttribute()
    {
        return $this->qr_code_path ? asset('storage/' . $this->qr_code_path) : null;
    }

    // Static methods
    public static function generateCertificateId($bootcampId)
    {
        $year = now()->year;
        $bootcamp = \App\Models\Bootcamp::find($bootcampId);
        $bootcampCode = strtoupper(substr(str_replace(' ', '', $bootcamp->title), 0, 3));
        
        $lastCert = static::where('bootcamp_id', $bootcampId)
                         ->whereYear('created_at', $year)
                         ->orderBy('id', 'desc')
                         ->first();
        
        $sequence = $lastCert ? (int)substr($lastCert->certificate_id, -6) + 1 : 1;
        
        return sprintf('LS-%s-%d-%06d', $bootcampCode, $year, $sequence);
    }

    public static function generateCertificateCode()
    {
        do {
            $code = 'VERIFY-' . strtoupper(Str::random(8));
        } while (static::where('certificate_code', $code)->exists());
        
        return $code;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($certificate) {
            if (!$certificate->certificate_id) {
                $certificate->certificate_id = static::generateCertificateId($certificate->bootcamp_id);
            }
            
            if (!$certificate->issued_at) {
                $certificate->issued_at = now();
            }
        });
    }
}