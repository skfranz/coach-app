<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Show a month-grid calendar of completed tasks.
     * Weeks start on Sunday. Times are interpreted in America/Chicago.
     */
    public function index(Request $request)
    {
        $tz = 'America/Chicago';

        $now = Carbon::now($tz);
        $year = intval($request->query('year', $now->year));
        $month = intval($request->query('month', $now->month));

        // Normalize month/year and create a Carbon for the first day of the month
        $monthStart = Carbon::create($year, $month, 1, 0, 0, 0, $tz);
        $monthEnd = $monthStart->copy()->endOfMonth();

        // Grid bounds: start on the Sunday before (or equal) the first, end on Saturday after (or equal) the last
        $gridStart = $monthStart->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $monthEnd->copy()->endOfWeek(Carbon::SATURDAY);

        // Fetch tasks completed within the grid window
        $tasks = Task::whereNotNull('completed_at')
            ->whereBetween('completed_at', [$gridStart->toDateTimeString(), $gridEnd->toDateTimeString()])
            ->orderBy('completed_at')
            ->get();

        // Group tasks by local date string (Y-m-d) (by day)
        $grouped = [];
        foreach ($tasks as $task) {
            $dateKey = $task->completed_at->setTimezone($tz)->format('Y-m-d');
            if (!isset($grouped[$dateKey])) $grouped[$dateKey] = [];
            $grouped[$dateKey][] = $task;
        }

        // Build weeks array (each week is array of 7 days with date and tasks)
        $weeks = [];
        $cursor = $gridStart->copy();
        while ($cursor->lte($gridEnd)) {
            $week = [];
            for ($d = 0; $d < 7; $d++) {
                $key = $cursor->format('Y-m-d');
                $week[] = [
                    'date' => $cursor->copy(),
                    'tasks' => $grouped[$key] ?? [],
                ];
                $cursor->addDay();
            }
            $weeks[] = $week;
        }

        $prev = $monthStart->copy()->subMonth();
        $next = $monthStart->copy()->addMonth();

        return view('calendar', [
            'weeks' => $weeks,
            'monthStart' => $monthStart,
            'prev' => $prev,
            'next' => $next,
            'tz' => $tz,
        ]);
    }
}
