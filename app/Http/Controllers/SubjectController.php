<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Tutor;
use App\Models\Timetable;
use App\Models\StudentList;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalTutors = Tutor::count();
        $totalStudents = StudentList::count();
    
        // Add this line:
        $subjects = Subject::withCount('timetables')->get();
    
        return view('subjects.index', compact('totalTutors', 'totalStudents', 'subjects'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $subjects = Subject::all(); // Fetch all subjects
        return view('subjects.create');
        // return view('tutors.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }

    public function cleanupOrphans()
{
    $subjectsWithoutTimetables = Subject::doesntHave('timetables')->get();

    foreach ($subjectsWithoutTimetables as $subject) {
        $subject->delete();
    }

    return redirect()->back()->with('success', 'Subjects without timetables deleted.');
}

public function getByLevel($level)
{
    $subjects = Subject::where('level', $level)->get();

    return response()->json([
        'subjects' => $subjects
    ]);
}


}
