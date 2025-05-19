<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('users.admin.subjects', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_code' => 'required|unique:subjects|max:50',
            'subject_name' => 'required|max:100',
            'subject_description' => 'nullable|max:255',
        ]);

        // Add the current user's ID to the request data
        $data = $request->all();
        $data['user_subject_id'] = auth()->id();

        Subject::create($data);

        return redirect()->route('admin.subjects')
            ->with('success', 'Subject created successfully.');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_code' => 'required|max:50|unique:subjects,subject_code,' . $subject->id,
            'subject_name' => 'required|max:100',
            'subject_description' => 'nullable|max:255',
        ]);

        // Keep the original creator ID when updating
        $data = $request->all();
        $data['user_subject_id'] = $subject->user_subject_id; // Preserve the original creator

        $subject->update($data);

        return redirect()->route('admin.subjects')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        // Optional: Check if the current user is the creator or has permission
        // if (auth()->id() !== $subject->user_subject_id) {
        //     abort(403, 'Unauthorized action.');
        // }

        $subject->delete();

        return redirect()->route('admin.subjects')
            ->with('success', 'Subject deleted successfully.');
    }
}
