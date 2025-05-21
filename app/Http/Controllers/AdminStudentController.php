<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->latest()->paginate(10);
        return view('users.admin.students', compact('students'));
    }

    public function update(Request $request, User $student)
    {
        // Ensure we're only updating students
        if ($student->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($student->id),
            ],
        ]);

        $student->update([
            'id_number' => $request->id_number,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.students')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        // Ensure we're only deleting students
        if ($student->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $student->delete();
        return redirect()->route('admin.students')
            ->with('success', 'Student deleted successfully.');
    }
}
