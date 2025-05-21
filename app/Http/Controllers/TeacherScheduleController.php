<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Exports\TeacherScheduleExport;
use Maatwebsite\Excel\Facades\Excel;

class TeacherScheduleController extends Controller
{
    public function index()
    {
        $schedules = auth()->user()->teacherSchedules()
            ->with(['subject', 'section', 'room', 'students'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('users.teachers.schedules', compact('schedules'));
    }

    public function export()
    {
        return Excel::download(new TeacherScheduleExport, 'teacher_schedule.xlsx');
    }
}
