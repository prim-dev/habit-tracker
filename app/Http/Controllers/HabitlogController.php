<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;

class HabitLogController extends Controller
{
    /**
     * Complete a habit for today
     */
    public function store(Habit $habit)
    {
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate completion
        |--------------------------------------------------------------------------
        */

        $alreadyCompleted = HabitLog::where('habit_id', $habit->id)
            ->where('completed_date', $today)
            ->exists();

        if ($alreadyCompleted) {
            return redirect()
                ->route('habits')
                ->with('error', 'Habit already completed today!');
        }

        /*
        |--------------------------------------------------------------------------
        | Save completion log
        |--------------------------------------------------------------------------
        */

        HabitLog::create([
            'habit_id' => $habit->id,
            'completed_date' => $today,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Streak Logic
        |--------------------------------------------------------------------------
        */

        if ($habit->last_completed) {

            $lastCompleted = Carbon::parse($habit->last_completed);

            // Completed yesterday = continue streak
            if ($lastCompleted->copy()->addDay()->isSameDay($today)) {

                $habit->streak += 1;

            } 
            // Missed days = reset streak
            elseif (!$lastCompleted->isSameDay($today)) {

                $habit->streak = 1;
            }

        } else {

            // First completion
            $habit->streak = 1;
        }

        /*
        |--------------------------------------------------------------------------
        | Update longest streak
        |--------------------------------------------------------------------------
        */

        if ($habit->streak > $habit->longest_streak) {
            $habit->longest_streak = $habit->streak;
        }

        /*
        |--------------------------------------------------------------------------
        | Save latest completion date
        |--------------------------------------------------------------------------
        */

        $habit->last_completed = $today;

        $habit->save();

        return redirect()
            ->route('habits')
            ->with('success', 'Habit completed successfully!');
    }
}