<?php

namespace App\Traits;

trait SequentialId
{
    /**
     * Boot the trait
     */
    protected static function bootSequentialId()
    {
        static::creating(function ($model) {
            $model->id = $model->getNextSequentialId();
        });
    }

    /**
     * Get the next sequential ID
     */
    public function getNextSequentialId()
    {
        // Get the highest ID currently in use
        $maxId = static::max('id') ?? 0;
        
        // Check for gaps in the sequence starting from 1
        for ($i = 1; $i <= $maxId + 1; $i++) {
            if (!static::where('id', $i)->exists()) {
                return $i;
            }
        }
        
        // If no gaps found, return next number
        return $maxId + 1;
    }

    /**
     * Disable auto-incrementing
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Set the key type
     */
    public function getKeyType()
    {
        return 'int';
    }
}