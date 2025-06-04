<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use App\Models\StudentList;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $tutor = Tutor::where('user_id', $user->id)->first();

    // If no tutor found, no attendances or subjects
    if (!$tutor) {
        return view('attendances.index', [
            'attendances' => collect(),
            'subjects' => collect(),
            'subjectClasses' => collect(),
        ]);
    }

    // Get all subjects assigned to the tutor (can be multiple if your DB supports it)
    // Currently you store one subject per tutor, so you get one
    $subjectsQuery = Subject::where('id', $tutor->subject_id);

    // For subjectClass dropdown (unique classes in tutor's subjects)
    $subjectClasses = $subjectsQuery->pluck('subject_class')->unique();

    // Add filter by subject_class if provided
    if ($request->filled('subject_class')) {
        $subjectsQuery->where('subject_class', $request->subject_class);
    }

    $subjects = $subjectsQuery->get();

    // Build attendances query filtered by tutor's subject(s)
    $query = Attendance::with(['student', 'subject', 'tutor.user'])
        ->where('tutor_id', $tutor->id);

    // Filter date
    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    // Filter subject_id (only allow subjects tutor teaches)
    if ($request->filled('subject_id')) {
        $query->where('subject_id', $request->subject_id);
    }

    // Filter by subject_class via relationship
    if ($request->filled('subject_class')) {
        $query->whereHas('subject', function ($q) use ($request) {
            $q->where('subject_class', $request->subject_class);
        });
    }

    $attendances = $query->latest()->paginate(10)->appends($request->all());

    return view('attendances.index', compact('attendances', 'subjects', 'subjectClasses'));
}



    public function create()
{
    $user = Auth::user();
    $tutor = Tutor::where('user_id', $user->id)->first();

    if (!$tutor) {
        return redirect()->back()->with('error', 'Tutor profile not found.');
    }

    // Get the subject assigned to this tutor
    $subjects = Subject::where('id', $tutor->subject_id)->get();

    // Get students enrolled in this subject
    $students = StudentList::whereHas('enrollments', function ($query) use ($tutor) {
        $query->where('subject_id', $tutor->subject_id);
    })->get();

    return view('attendances.create', compact('subjects', 'students'));
}


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:student_lists,id',
        ]);

        $tutor = Tutor::where('user_id', Auth::id())->first();

        if (!$tutor) {
            return redirect()->back()->with('error', 'Tutor profile not found.');
        }

        foreach ($request->student_ids as $studentId) {
            Attendance::create([
                'date' => $request->date,
                'student_id' => $studentId,
                'subject_id' => $request->subject_id,
                'tutor_id' => $tutor->id,
            ]);
        }

        return redirect()->route('attendances.index')->with('success', 'Attendance submitted successfully!');
    }
}
