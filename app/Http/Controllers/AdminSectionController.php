<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class AdminSectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('creator')->latest()->paginate(10);
        return view('users.admin.sections', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|max:100',
            'section_level' => 'required|max:50',
        ]);

        // Automatically set the current user as creator
        Section::create([
            'section_name' => $request->section_name,
            'section_level' => $request->section_level,
            'user_section_id' => auth()->id(), // Set creator ID
        ]);

        return redirect()->route('admin.sections')
            ->with('success', 'Section created successfully.');
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'section_name' => 'required|max:100',
            'section_level' => 'required|max:50',
        ]);

        // Keep the original creator when updating
        $section->update([
            'section_name' => $request->section_name,
            'section_level' => $request->section_level,

        ]);

        return redirect()->route('admin.sections')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections')
            ->with('success', 'Section deleted successfully.');
    }
}
