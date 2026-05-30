<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'streak',
        'longest_streak',
        'category',
        'last_completed',
    ];

    protected $casts = [
        'last_completed' => 'date',
    ];

    /**
     * Habit Logs Relationship
     */
    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }

    /**
     * Total completions
     */
    public function totalCompletions()
    {
        return $this->logs()->count();
    }
}