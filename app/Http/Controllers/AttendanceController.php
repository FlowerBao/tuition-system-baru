<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\StudentList;
use App\Models\Tutor;
use App\Models\ParentInfo;
use App\Models\Enrollment;
use Carbon\Carbon;
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


 public function parentView(Request $request)
{
    $userId = Auth::id();
    $selectedStudentId = $request->input('student_id');
    $selectedSubjectId = $request->input('subject_id');
    $selectedMonth = $request->input('month') ?? now()->format('Y-m');

    $parentInfo = ParentInfo::where('user_id', $userId)->first();
    if (!$parentInfo) {
        return redirect()->back()->withErrors('Parent profile not found.');
    }

    $students = StudentList::where('parent_id', $parentInfo->id)->get();
    $studentIds = $students->pluck('id');

    // Get enrollments of students to get their subject days
    $enrolledSubjectIds = Attendance::whereIn('student_id', $studentIds)
        ->pluck('subject_id')
        ->unique();

    if ($selectedSubjectId) {
        $enrolledSubjectIds = $enrolledSubjectIds->filter(fn($id) => $id == $selectedSubjectId);
    }

    // Fetch the days these subjects are scheduled (e.g., Monday, Tuesday)
    $scheduledDays = Timetable::whereIn('subject_id', $enrolledSubjectIds)
        ->pluck('day')
        ->unique()
        ->map(fn($day) => strtolower($day)); // Ensure day format matches Carbon::dayName

    // Filter month dates to include only those matching the scheduled days
    $yearMonth = Carbon::createFromFormat('Y-m', $selectedMonth);
    $datesInMonth = collect(range(1, $yearMonth->daysInMonth))->map(function ($day) use ($yearMonth, $scheduledDays) {
        $date = $yearMonth->copy()->day($day);
        return $scheduledDays->contains(strtolower($date->format('l'))) ? $date->toDateString() : null;
    })->filter();

    // Attendance records filtered by month and selected filters
    $attendanceQuery = Attendance::with(['student', 'subject', 'tutor'])
        ->whereIn('student_id', $studentIds)
        ->whereIn('date', $datesInMonth);

    if ($selectedStudentId) {
        $attendanceQuery->where('student_id', $selectedStudentId);
    }

    if ($selectedSubjectId) {
        $attendanceQuery->where('subject_id', $selectedSubjectId);
    }

    $attendances = $attendanceQuery->get();
    $groupedAttendances = $attendances->groupBy(fn($a) => $a->student_id . '-' . $a->date);
    $subjects = Subject::whereIn('id', $attendances->pluck('subject_id')->unique())->get();

    return view('parents.attendance', compact(
        'students',
        'groupedAttendances',
        'selectedStudentId',
        'selectedSubjectId',
        'selectedMonth',
        'datesInMonth',
        'subjects'
    ));
}

}
