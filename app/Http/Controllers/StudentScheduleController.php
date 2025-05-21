<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\StudentScheduleExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentScheduleController extends Controller
{
    public function index()
    {
        $schedules = auth()->user()->schedules()
            ->with(['subject', 'section', 'room', 'teacher'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('users.students.schedules', compact('schedules'));
    }

    public function export()
    {
        return Excel::download(new StudentScheduleExport, 'my_schedule.xlsx');
    }
}
