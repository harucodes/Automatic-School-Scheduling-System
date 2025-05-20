<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')->latest()->paginate(10);
        return view('users.admin.teachers', compact('teachers'));
    }

    public function update(Request $request, User $teacher)
    {
        // Ensure we're only updating teachers
        if ($teacher->role !== 'teacher') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($teacher->id),
            ],
        ]);

        $teacher->update([
            'id_number' => $request->id_number,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.teachers')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(User $teacher)
    {
        // Ensure we're only deleting teachers
        if ($teacher->role !== 'teacher') {
            abort(403, 'Unauthorized action.');
        }

        $teacher->delete();
        return redirect()->route('admin.teachers')
            ->with('success', 'Teacher deleted successfully.');
    }
}
