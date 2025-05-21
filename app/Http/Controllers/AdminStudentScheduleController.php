<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminStudentScheduleController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        $availableSchedules = Schedule::with(['subject', 'section', 'room', 'teacher'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('users.admin.student-schedules', compact('students', 'availableSchedules'));
    }

    public function getStudentSchedules($studentId)
    {
        $user = User::with([
            'schedules.subject',
            'schedules.teacher',
            'schedules.section',
            'schedules.room'
        ])->findOrFail($studentId);

        return response()->json($user->schedules);
    }



    public function store(Request $request)
    {
        $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        // Get the schedule being assigned
        $schedule = DB::table('schedules')->where('id', $request->schedule_id)->first();

        // Check if the assignment already exists
        $exists = DB::table('schedule_student')
            ->where('schedule_id', $request->schedule_id)
            ->where('user_student_id', $request->user_student_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule_id' => 'This student is already assigned to this schedule.']);
        }

        // Check for schedule conflicts
        $conflict = DB::table('schedule_student')
            ->join('schedules', 'schedule_student.schedule_id', '=', 'schedules.id')
            ->where('user_student_id', $request->user_student_id)
            ->where('schedules.day', $schedule->day)
            ->where(function ($query) use ($schedule) {
                $query->whereBetween('schedules.start_time', [$schedule->start_time, $schedule->end_time])
                    ->orWhereBetween('schedules.end_time', [$schedule->start_time, $schedule->end_time]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['schedule_id' => 'This schedule conflicts with another schedule the student has.']);
        }

        // Assign the schedule
        DB::table('schedule_student')->insert([
            'schedule_id' => $request->schedule_id,
            'user_student_id' => $request->user_student_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.student-schedules.index')
            ->with('success', 'Schedule assigned to student successfully.');
    }


    public function destroy($assignmentId)
    {
        DB::table('schedule_student')->where('id', $assignmentId)->delete();

        return redirect()->route('admin.student-schedules.index')
            ->with('success', 'Schedule removed from student successfully.');
    }
}
