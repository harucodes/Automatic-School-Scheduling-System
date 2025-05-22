<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{


    public function index()
    {
        // Counts
        $studentCount = User::where('role', 'student')->count();
        $teacherCount = User::where('role', 'teacher')->count();
        $roomCount = Room::count();
        $scheduleCount = Schedule::count();

        // Students per Section using student_schedule
        $studentsPerSection = DB::table('sections')
            ->select('sections.section_name', DB::raw('COUNT(DISTINCT schedule_student.user_student_id) as student_count'))
            ->leftJoin('schedules', 'sections.id', '=', 'schedules.section_id')
            ->leftJoin('schedule_student', 'schedules.id', '=', 'schedule_student.schedule_id')
            ->leftJoin('users', function ($join) {
                $join->on('schedule_student.user_student_id', '=', 'users.id')
                    ->where('users.role', 'student');
            })
            ->groupBy('sections.section_name')
            ->get();

        $roomUtilization = DB::table('rooms')
            ->leftJoin('schedules', 'rooms.id', '=', 'schedules.room_id')
            ->leftJoin('schedule_student', 'schedules.id', '=', 'schedule_student.schedule_id')
            ->select('rooms.room_number', DB::raw('COUNT(schedule_student.user_student_id) as students_count'))
            ->groupBy('rooms.id', 'rooms.room_number')
            ->get();
        $roomLabels = $roomUtilization->pluck('room_number')->toArray();
        $roomCounts = $roomUtilization->pluck('students_count')->toArray();



        return view('users.admin.home', compact(
            'studentCount',
            'teacherCount',
            'roomCount',
            'scheduleCount',
            'studentsPerSection',
            'roomLabels',
            'roomCounts',
        ));
    }
}
