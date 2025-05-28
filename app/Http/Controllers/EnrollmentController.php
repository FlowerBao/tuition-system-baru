<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\StudentList;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $user = auth()->user();

    // Get parent info for the logged-in parent
    $parentInfo = \App\Models\ParentInfo::where('user_id', $user->id)->first();

    if (!$parentInfo) {
        return redirect()->back()->withErrors(['parent' => 'Parent info not found.']);
    }

    // Get only students belonging to this parent
    $students = \App\Models\StudentList::where('parent_id', $parentInfo->id)->get();

    // Get all subjects for now (will be filtered in Blade based on student level)
    $subjects = \App\Models\Subject::all();

    return view('enrollments.create', compact('students', 'subjects'));
}





    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_lists,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Prevent duplicate enrollment
        $alreadyEnrolled = Enrollment::where('student_id', $request->student_id)
                                     ->where('subject_id', $request->subject_id)
                                     ->exists();

        if ($alreadyEnrolled) {
            return redirect()->back()->withErrors(['already_enrolled' => 'Student is already enrolled in this subject.']);
        }

        Enrollment::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('student_lists.index')->with('success', 'Student enrolled in subject successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
