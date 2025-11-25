<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'youtube_url',
        'video_type', // 'upload' or 'youtube'
        'thumbnail',
        'duration',
        'class_id',
        'bootcamp_id',
        'order',
        'status',
        'created_by'
    ];

    protected $casts = [
        'duration' => 'integer',
        'order' => 'integer'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class, 'bootcamp_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'created_by');
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

    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeByBootcamp($query, $bootcampId)
    {
        return $query->where('bootcamp_id', $bootcampId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Helper methods
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return 'N/A';
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getTypeAttribute()
    {
        return $this->class_id ? 'class' : 'bootcamp';
    }

    public function getParentAttribute()
    {
        return $this->class_id ? $this->class : $this->bootcamp;
    }

    // Video progress relationship
    public function progress()
    {
        return $this->hasMany(VideoProgress::class);
    }

    public function userProgress($userId)
    {
        return $this->progress()->where('user_id', $userId)->first();
    }

    // YouTube helpers
    public function getYoutubeIdAttribute()
    {
        if (!$this->youtube_url) return null;
        
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }

    public function getVideoSourceAttribute()
    {
        if ($this->video_type === 'youtube' && $this->youtube_url) {
            return $this->youtube_embed_url;
        }
        
        return $this->video_url ? asset('storage/' . $this->video_url) : null;
    }
}
