<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit;
use App\Models\User;
use App\Models\HabitLog;

class HabitController extends Controller
{
    /**
     * Show dashboard with habits and stats
     */
    public function index()
    {
        // Load habits with logs
        $habits = Habit::with('logs')
            ->latest()
            ->get();

        // Dashboard stats
        $totalUsers       = User::count();
        $totalHabits      = Habit::count();
        $totalCompletions = HabitLog::count();

        return view('welcome', [
            'habits'          => $habits,
            'totalUsers'      => $totalUsers,
            'totalHabits'     => $totalHabits,
            'totalCompletions'=> $totalCompletions,
        ]);
    }

    /**
     * Store a new habit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable|max:500',
        ]);

        Habit::create([
            'title'          => $validated['title'],
            'description'    => $validated['description'] ?? null,
            'streak'         => 0,
            'longest_streak' => 0,
        ]);

        return redirect()
            ->route('habits')
            ->with('success', 'Habit added successfully!');
    }

    /**
     * Delete a habit
     */
    public function destroy(Habit $habit)
    {
        $habit->delete();

        return redirect()
            ->route('habits')
            ->with('success', 'Habit deleted successfully!');
    }
}
