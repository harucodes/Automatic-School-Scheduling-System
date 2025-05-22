<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use App\Models\Section;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['subject', 'teacher', 'section', 'room'])
            ->latest()
            ->paginate(10);

        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();
        $sections = Section::all();
        $rooms = Room::all();

        return view('users.admin.schedules', compact(
            'schedules',
            'subjects',
            'teachers',
            'sections',
            'rooms'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'user_teacher_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:sections,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for schedule conflicts
        $conflict = Schedule::where('day', $request->day)
            ->where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['time' => 'The selected time slot conflicts with an existing schedule for this room.']);
        }

        Schedule::create($request->all());

        return redirect()->route('admin.schedules')
            ->with('success', 'Schedule created successfully.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'user_teacher_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:sections,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);


        // Check for schedule conflicts (excluding current schedule)
        $conflict = Schedule::where('day', $request->day)
            ->where('room_id', $request->room_id)
            ->where('id', '!=', $schedule->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['time' => 'The selected time slot conflicts with an existing schedule for this room.']);
        }

        $schedule->update($request->all());

        return redirect()->route('admin.schedules')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules')
            ->with('success', 'Schedule deleted successfully.');
    }
}
