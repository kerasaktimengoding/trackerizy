<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HabitTrackerController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        $date = Carbon::parse($selectedDate);

        $habits = Habit::where('is_active', true)->get()->map(function ($habit) use ($date) {
            $log = $habit->logs()->where('date', $date->toDateString())->first();
            $habit->is_completed_on_date = $log ? (bool) $log->completed : false;
            $habit->current_streak = $habit->currentStreak();
            return $habit;
        });

        $totalHabits = $habits->count();
        $completedHabits = $habits->where('is_completed_on_date', true)->count();
        $progressPercent = $totalHabits > 0 ? round(($completedHabits / $totalHabits) * 100) : 0;

        // 7 hari terakhir untuk mini weekly streak calendar
        $weekDays = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $weekDays->push([
                'date' => $day->toDateString(),
                'day_name' => $day->locale('id')->isoFormat('ddd'),
                'day_num' => $day->format('d'),
                'is_today' => $day->isToday(),
                'is_selected' => $day->toDateString() === $date->toDateString(),
            ]);
        }

        return view('tracker.index', compact(
            'habits',
            'date',
            'totalHabits',
            'completedHabits',
            'progressPercent',
            'weekDays'
        ));
    }

    public function toggle(Request $request, Habit $habit)
    {
        $request->validate([
            'date' => 'nullable|date',
        ]);

        $date = $request->input('date', Carbon::today()->toDateString());

        $log = HabitLog::firstOrNew([
            'habit_id' => $habit->id,
            'date' => $date,
        ]);

        $log->completed = !$log->completed;
        $log->count = $log->completed ? ($habit->target_per_day ?: 1) : 0;
        $log->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'completed' => $log->completed,
                'streak' => $habit->currentStreak(),
            ]);
        }

        return redirect()->back();
    }
}
