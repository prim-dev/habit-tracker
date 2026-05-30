<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Habit;
use App\Models\HabitLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalHabits = Habit::count();

        $totalCompletions = HabitLog::count();

        return view('dashboard', compact(
            'totalUsers',
            'totalHabits',
            'totalCompletions'
        ));
    }
}