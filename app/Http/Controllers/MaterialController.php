<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\Enrollment;
use App\Models\StudentList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // === Parent Role ===
        if ($role === 'parents') {
            $students = StudentList::where('parent_id', $user->id)->get();
            $selectedStudentId = $request->input('student_id');
            $selectedSubjectId = $request->input('subject_id');

            $studentIds = $students->pluck('id');
            $enrollments = Enrollment::whereIn('student_id', $studentIds);

            if ($selectedStudentId) {
                $enrollments->where('student_id', $selectedStudentId);
            }

            if ($selectedSubjectId) {
                $enrollments->where('subject_id', $selectedSubjectId);
            }

            $subjectIds = $enrollments->pluck('subject_id')->unique();
            $materials = Material::whereIn('subject_id', $subjectIds)->latest()->get();
            $subjects = Subject::whereIn('id', $subjectIds)->get();

            return view('materials.index', [
                'materials' => $materials,
                'isParent' => true,
                'isTutor' => false,
                'students' => $students,
                'subjects' => $subjects,
            ]);
        }

        // === Tutor Role ===
        if ($role === 'tutor') {
            $tutorSubjectIds = Tutor::where('user_id', $user->id)->pluck('subject_id');
            $materials = Material::whereIn('subject_id', $tutorSubjectIds)->latest()->get();
            $subjects = Subject::whereIn('id', $tutorSubjectIds)->get();

            return view('materials.index', [
                'materials' => $materials,
                'isParent' => false,
                'isTutor' => true,
                'students' => [],
                'subjects' => $subjects,
            ]);
        }

        // === Admin or Other Roles ===
        $materials = Material::latest()->get();
        return view('materials.index', [
            'materials' => $materials,
            'isParent' => false,
            'isTutor' => false,
            'students' => [],
            'subjects' => Subject::all(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tutor = Tutor::where('user_id', auth()->user()->id)->first();

        if (!$tutor) {
            return redirect()->route('dashboard')->withErrors('No tutor found for the logged-in user.');
        }

        $subjects = Subject::where('id', $tutor->subject_id)->get();
        return view('materials.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $tutor = Tutor::where('user_id', auth()->user()->id)->first();
                    if (!$tutor || $tutor->subject_id != $value) {
                        $fail('The selected subject is invalid for this tutor.');
                    }
                },
            ],
            'file' => 'required|file|mimes:pdf,docx,pptx|max:2048',
        ]);

        $tutor = Tutor::where('user_id', auth()->user()->id)->first();

        $filePath = $request->file('file')->store('materials', 'public');

        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => now(),
            'file_path' => $filePath,
            'subject_id' => $request->subject_id,
            'tutor_id' => $tutor->id,
        ]);

        return redirect()->route('materials.index')->with('success', 'Material uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        // Optional: implement if you want to show detailed view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        // Optional: implement if you allow editing
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        // Optional: implement if you allow updating
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}