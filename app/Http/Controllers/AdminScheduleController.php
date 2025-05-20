<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use App\Models\Section;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        /*  Log::info('Admin accessed the schedule index page.');
 */
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

        Log::info('Attempting to store a new schedule.', $request->all());

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
            Log::warning('Schedule conflict detected during store.', [
                'room_id' => $request->room_id,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return back()->withErrors(['time' => 'The selected time slot conflicts with an existing schedule for this room.']);
        }

        Schedule::create($request->all());

        Log::info('Schedule created successfully.', $request->all());

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

        Log::info('Attempting to update schedule.', [
            'schedule_id' => $schedule->id,
            'data' => $request->all()
        ]);

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
            Log::warning('Schedule conflict detected during update.', [
                'schedule_id' => $schedule->id,
                'room_id' => $request->room_id,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return back()->withErrors(['time' => 'The selected time slot conflicts with an existing schedule for this room.']);
        }

        $schedule->update($request->all());

        Log::info('Schedule updated successfully.', [
            'schedule_id' => $schedule->id,
            'data' => $request->all()
        ]);

        return redirect()->route('admin.schedules')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        Log::info('Attempting to delete schedule.', [
            'schedule_id' => $schedule->id,
        ]);

        $schedule->delete();

        Log::info('Schedule deleted successfully.', [
            'schedule_id' => $schedule->id,
        ]);

        return redirect()->route('admin.schedules')
            ->with('success', 'Schedule deleted successfully.');
    }
}
