<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'class_id',
        'bootcamp_id',
        'full_name',
        'email',
        'phone',
        'whatsapp',
        'amount',
        'payment_method',
        'payment_type',
        'transaction_id',
        'snap_token',
        'midtrans_response',
        'status',
        'payment_date',
        'midtrans_paid_at',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'midtrans_paid_at' => 'datetime',
        'midtrans_response' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class, 'bootcamp_id');
    }

    // Helper method to get customer name
    public function getCustomerNameAttribute()
    {
        return $this->full_name ?: ($this->user ? $this->user->name : 'Guest');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
