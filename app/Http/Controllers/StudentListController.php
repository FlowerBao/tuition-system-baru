<?php

namespace App\Http\Controllers;

use App\Models\StudentList;
use App\Models\ParentInfo;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentListController extends Controller
{
//     public function index()
// {
//     // Fetch students associated with the logged-in parent
//     $studentLists = StudentList::where('parent_id', auth()->user()->parentInfo->id)->paginate(10);
    
//     return view('studentLists.index', compact('studentLists'));
// }

    public function index()
    {
    // Eager load enrollments and their related subjects for the students of the logged-in parent
    $studentLists = StudentList::with('enrollments.subject')
        ->where('parent_id', auth()->user()->parentInfo->id)
        ->paginate(10);

    return view('studentLists.index', compact('studentLists'));
    }


    public function create()
    {
        $subjects = Subject::all(); // fetch all subjects
        return view('studentLists.create', compact('subjects'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'ic' => 'required|string|max:20|unique:student_lists,ic', // ensure IC is unique in student_lists
        'level' => 'required|string|max:255',
        'phone' => 'nullable|string|max:15',
        'subject_id' => 'required|exists:subjects,id',
    ]);

    $user = Auth::user();
    $parentInfo = \App\Models\ParentInfo::where('user_id', $user->id)->first();

    if (!$parentInfo) {
        return redirect()->back()->withErrors(['parent' => 'Parent info not found.']);
    }

    // Store student data directly without user account
    $student = \App\Models\StudentList::create([
        'name' => $request->name,
        'ic' => $request->ic,
        'level' => $request->level,
        'phone' => $request->phone,
        'parent_id' => $parentInfo->id,
    ]);

    // Create enrollment record linking student and subject
    \App\Models\Enrollment::create([
        'student_id' => $student->id,
        'subject_id' => $request->subject_id,
    ]);

    return redirect()->route('student_lists.index')->with('success', 'Student registered and enrolled successfully!');
}


    
    public function dashboardAdmin()
    {
        $totalTutors = \App\Models\Tutor::count();
        $totalStudents = StudentList::count();

        return view('dashboardAdmin', compact('totalTutors', 'totalStudents'));
    }

    public function adminStudentList()
{
    $studentLists = StudentList::with('subject')->paginate(10);
    return view('studentLists.admin_index', compact('studentLists'));
}


}
