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

    public function calendar(Request $request)
    {
        $viewType = $request->query('view', 'monthly'); // 'weekly', 'monthly', 'yearly'
        $month = $request->query('month', Carbon::today()->format('Y-m'));
        $year = $request->query('year', Carbon::today()->year);

        $habits = Habit::where('is_active', true)->with('logs')->get();
        $totalHabits = $habits->count();

        // 1. STATISTIK UTAMA
        // Tentukan rentang tanggal sesuai viewType
        if ($viewType === 'weekly') {
            $startDate = Carbon::today()->startOfWeek();
            $endDate = Carbon::today()->endOfWeek();
        } elseif ($viewType === 'yearly') {
            $startDate = Carbon::today()->subYear()->addDay();
            $endDate = Carbon::today();
        } else { // monthly
            $startDate = Carbon::parse($month . '-01')->startOfMonth();
            $endDate = Carbon::parse($month . '-01')->endOfMonth();
        }

        $allLogsInRange = HabitLog::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->where('completed', true)
            ->get();

        $totalDone = $allLogsInRange->count();
        $daysCount = $startDate->diffInDays($endDate) + 1;
        $maxPossible = $totalHabits * $daysCount;
        $percentSuccess = $maxPossible > 0 ? round(($totalDone / $maxPossible) * 100) : 0;

        // Best Day (Hari tersering tuntas: Senin/Selasa/dst)
        $dayGroups = $allLogsInRange->groupBy(function ($log) {
            return Carbon::parse($log->date)->locale('id')->isoFormat('dddd');
        });
        $bestDayName = '-';
        $bestDayCount = 0;
        foreach ($dayGroups as $dayName => $logs) {
            if ($logs->count() > $bestDayCount) {
                $bestDayCount = $logs->count();
                $bestDayName = $dayName;
            }
        }
        $bestDay = $bestDayCount > 0 ? $bestDayName : 'Belum Ada';

        // Best Streak (rekor streak tertinggi saat ini dari seluruh habit)
        $bestStreak = $habits->map(fn($h) => $h->currentStreak())->max() ?? 0;

        // 2. DATA UNTUK VIEW MINGGUAN (Weekly)
        $weeklyDays = collect();
        $weekPointer = Carbon::today()->startOfWeek();
        for ($i = 0; $i < 7; $i++) {
            $d = $weekPointer->copy()->addDays($i);
            $weeklyDays->push([
                'date' => $d->toDateString(),
                'day_name' => $d->locale('id')->isoFormat('ddd'),
                'day_number' => $d->format('d'),
                'is_today' => $d->isToday(),
            ]);
        }

        // 3. DATA UNTUK VIEW BULANAN (Monthly Calendar Per Habit)
        $currentMonth = Carbon::parse($month . '-01');
        $daysInMonth = $currentMonth->daysInMonth;
        $startDayOfWeek = $currentMonth->copy()->startOfMonth()->dayOfWeekIso; // 1 (Senin) .. 7 (Minggu)
        
        $monthlyHabits = $habits->map(function ($habit) use ($currentMonth, $daysInMonth) {
            $logs = $habit->logs()
                ->whereYear('date', $currentMonth->year)
                ->whereMonth('date', $currentMonth->month)
                ->where('completed', true)
                ->pluck('date')
                ->map(fn($d) => Carbon::parse($d)->day)
                ->toArray();

            $habit->completed_days = array_flip($logs);
            $habit->month_done_count = count($logs);
            $habit->month_percent = $daysInMonth > 0 ? round((count($logs) / $daysInMonth) * 100) : 0;
            return $habit;
        });

        // 4. DATA UNTUK VIEW TAHUNAN (GitHub-style Contribution Graph 365 Days)
        $yearlyContributions = [];
        $today = Carbon::today();
        $yearStart = $today->copy()->subDays(364); // 52 minggu x 7 hari = 364 hari

        $yearLogsGrouped = HabitLog::whereBetween('date', [$yearStart->toDateString(), $today->toDateString()])
            ->where('completed', true)
            ->get()
            ->groupBy(fn($l) => Carbon::parse($l->date)->toDateString());

        $cursor = $yearStart->copy();
        while ($cursor <= $today) {
            $dateStr = $cursor->toDateString();
            $count = isset($yearLogsGrouped[$dateStr]) ? $yearLogsGrouped[$dateStr]->count() : 0;

            // Tentukan level warna kontribusi (0 s/d 4)
            $level = 0;
            if ($count > 0 && $totalHabits > 0) {
                $ratio = $count / $totalHabits;
                if ($ratio <= 0.25) $level = 1;
                elseif ($ratio <= 0.50) $level = 2;
                elseif ($ratio <= 0.75) $level = 3;
                else $level = 4;
            }

            $yearlyContributions[] = [
                'date' => $dateStr,
                'count' => $count,
                'level' => $level,
                'day_of_week' => $cursor->dayOfWeekIso, // 1 (Mon) to 7 (Sun)
                'month_name' => $cursor->locale('id')->isoFormat('MMM'),
            ];
            $cursor->addDay();
        }

        return view('tracker.calendar', compact(
            'viewType',
            'month',
            'year',
            'currentMonth',
            'habits',
            'totalHabits',
            'totalDone',
            'percentSuccess',
            'bestDay',
            'bestStreak',
            'weeklyDays',
            'monthlyHabits',
            'daysInMonth',
            'startDayOfWeek',
            'yearlyContributions'
        ));
    }
}

