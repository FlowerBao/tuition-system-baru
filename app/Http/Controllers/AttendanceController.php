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
    $query = Attendance::with(['student', 'subject', 'tutor.user']);

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    if ($request->filled('subject_id')) {
        $query->where('subject_id', $request->subject_id);
    }

    $user = Auth::user();
    $tutor = Tutor::where('user_id', $user->id)->first();
    $subjects = $tutor ? Subject::where('id', $tutor->subject_id)->get() : collect();

    $attendances = $query->latest()->paginate(10);

    return view('attendances.index', compact('attendances', 'subjects'));
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
