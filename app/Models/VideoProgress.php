<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_content_id',
        'class_id',
        'watch_time',
        'total_duration',
        'progress_percentage',
        'is_completed',
        'completed_at'
    ];

    protected $casts = [
        'watch_time' => 'integer',
        'total_duration' => 'integer',
        'progress_percentage' => 'decimal:2',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videoContent()
    {
        return $this->belongsTo(VideoContent::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Helper methods
    public function updateProgress($watchTime, $totalDuration)
    {
        $this->watch_time = $watchTime;
        $this->total_duration = $totalDuration;
        $this->progress_percentage = $totalDuration > 0 ? ($watchTime / $totalDuration) * 100 : 0;
        
        // Mark as completed if watched 90% or more
        if ($this->progress_percentage >= 90 && !$this->is_completed) {
            $this->is_completed = true;
            $this->completed_at = now();
        }
        
        $this->save();
        return $this;
    }

    public function getFormattedWatchTimeAttribute()
    {
        $minutes = floor($this->watch_time / 60);
        $seconds = $this->watch_time % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
