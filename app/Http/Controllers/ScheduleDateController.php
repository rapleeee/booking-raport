<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDate;
use Illuminate\Http\Request;

class ScheduleDateController extends Controller
{
    public function index()
    {
        $dates = ScheduleDate::orderBy('tanggal', 'asc')->get();
        return view('admin.schedule_dates.index', compact('dates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:schedule_dates,tanggal',
            'time_slots' => 'nullable|string'
        ]);

        $slots = [];
        if ($request->filled('time_slots')) {
            $rawSlots = explode(',', $request->time_slots);
            foreach ($rawSlots as $slot) {
                $time = trim($slot);
                if (preg_match('/^([01]?[0-9]|2[0-3])[:.][0-5][0-9]$/', $time)) {
                    $time = str_replace('.', ':', $time);
                    if (strlen($time) == 4) $time = '0' . $time;
                    $slots[] = $time . ':00';
                }
            }
            sort($slots);
        }

        ScheduleDate::create([
            'tanggal' => $request->tanggal,
            'time_slots' => count($slots) > 0 ? $slots : null,
            'is_active' => true
        ]);

        return back()->with('success', 'Tanggal ditambahkan!');
    }

    public function destroy(ScheduleDate $scheduleDate)
    {
        $scheduleDate->delete();
        return back()->with('success', 'Tanggal dihapus!');
    }

    public function toggle(ScheduleDate $scheduleDate)
    {
        $scheduleDate->update([
            'is_active' => !$scheduleDate->is_active
        ]);
        return back()->with('success', 'Status diubah!');
    }
}
