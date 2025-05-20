<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('creator')->latest()->paginate(10);
        return view('users.admin.rooms', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms|max:50',
            'capacity' => 'required|integer|min:1',
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'user_room_id' => auth()->id(), // Set creator ID
        ]);

        return redirect()->route('admin.rooms')
            ->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|max:50|unique:rooms,room_number,' . $room->id,
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            // user_room_id remains unchanged
        ]);

        return redirect()->route('admin.rooms')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms')
            ->with('success', 'Room deleted successfully.');
    }
}
