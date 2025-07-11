<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\StudentList;
use App\Models\ParentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimetableController extends Controller
{
   public function index(Request $request)
{
    $selectedLevel = $request->input('level');
    $selectedClass = $request->input('subject_class');

    // Build timetable query with filters
    $timetableQuery = Timetable::with('subject');

    if ($selectedLevel) {
        $timetableQuery->whereHas('subject', function ($q) use ($selectedLevel) {
            $q->where('level', $selectedLevel);
        });
    }

    if ($selectedClass) {
        $timetableQuery->whereHas('subject', function ($q) use ($selectedClass) {
            $q->where('subject_class', $selectedClass);
        });
    }

    $timetableList = $timetableQuery->get();

    // Count distinct subjects in timetableList
    $totalSubjects = $timetableList->pluck('subject.id')->unique()->count();

    // Your existing subject report query with filters
    $subjectReportQuery = DB::table('subjects')
        ->leftJoin('enrollments', 'subjects.id', '=', 'enrollments.subject_id')
        ->leftJoin('student_lists', 'enrollments.student_id', '=', 'student_lists.id')
        ->select('subjects.name as subject', 'subjects.level', 'subjects.subject_class', DB::raw('COUNT(student_lists.id) as student_count'))
        ->groupBy('subjects.name', 'subjects.level', 'subjects.subject_class');

    if ($selectedLevel) {
        $subjectReportQuery->where('subjects.level', $selectedLevel);
    }

    if ($selectedClass) {
        $subjectReportQuery->where('subjects.subject_class', $selectedClass);
    }

    $subjectReport = $subjectReportQuery->paginate(10);

    // Chart data logic stays the same...
    $getChartData = function ($levelName) use ($selectedClass) {
        $query = DB::table('subjects')
            ->join('enrollments', 'subjects.id', '=', 'enrollments.subject_id')
            ->join('student_lists', 'enrollments.student_id', '=', 'student_lists.id')
            ->where('subjects.level', $levelName)
            ->select('subjects.name as subject', DB::raw('COUNT(student_lists.id) as student_count'))
            ->groupBy('subjects.name');

        if ($selectedClass) {
            $query->where('subjects.subject_class', $selectedClass);
        }

        return $query->get();
    };

    $menengahSubjects = $getChartData('sekolah menengah');
    $rendahSubjects = $getChartData('sekolah rendah');
    $agamaSubjects = $getChartData('sekolah agama');

    $levels = Subject::select('level')->distinct()->pluck('level');
    $subjectClasses = Subject::select('subject_class')->distinct()->pluck('subject_class');

    return view('timetables.index', compact(
        'timetableList',
        'subjectReport',
        'menengahSubjects',
        'rendahSubjects',
        'agamaSubjects',
        'levels',
        'subjectClasses',
        'selectedLevel',
        'selectedClass',
        'totalSubjects' // <-- pass this to the view!
    ));
}

    public function create()
    {
        $subjects = Subject::all();
        $tutors = User::where('role', 'tutor')->get();
        return view('timetables.create', compact('subjects', 'tutors'));
    }

    public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'level' => 'required|string',
        'subject_class' => 'required|integer',
        'day' => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'classroom_name' => 'required|string|max:255',
    ]);

    // Create the subject
    $subject = Subject::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'level' => $validated['level'],
        'subject_class' => $validated['subject_class'],
    ]);

    // Create the timetable linked to this subject
    Timetable::create([
        'subject_id' => $subject->id,
        'day' => $validated['day'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
        'classroom_name' => $validated['classroom_name'],
    ]);

    return redirect()->route('timetables.index')->with('success', 'Subject and timetable registered successfully.');
}

    public function show(Timetable $timetable)
    {
        return view('timetables.show', compact('timetable'));
    }

    public function edit(Timetable $timetable)
    {
        $subjects = Subject::all();
        $level = $timetable->subject->level;
        $subjectClass = $timetable->subject->subject_class;

        return view('timetables.edit', compact('timetable', 'subjects', 'level', 'subjectClass'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
            'level' => 'required|string',
            'subject_class' => 'required|integer',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'classroom_name' => 'required|string',
        ]);

        $subject = $timetable->subject;
        $subject->update([
            'level' => $validated['level'],
            'subject_class' => $validated['subject_class'],
            'price' => $validated['price'],
        ]);

        $timetable->update([
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'classroom_name' => $validated['classroom_name'],
        ]);

        return redirect()->route('timetables.index')->with('success', 'Timetable updated successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->subject()->delete(); 
        $timetable->delete();
        return redirect()->route('timetables.index')->with('success', 'Timetable deleted successfully.');
    }

    public function display(Request $request)
{
    $userId = Auth::id();
    $levelFilter = $request->query('level');
    $query = Timetable::with('subject');

    // === Admin ===
    if (Auth::user()->is_admin) {
        if ($levelFilter) {
            $query->whereHas('subject', fn($q) => $q->where('level', $levelFilter));
        }
        $timetables = $query->get();
        $levels = Subject::select('level')->distinct()->pluck('level');
        return view('timetables.display', compact('timetables', 'levels'));
    }

    // === Tutor ===
    if (Auth::user()->role === 'tutor') {
        $subjectIds = Tutor::where('user_id', $userId)->pluck('subject_id');
        $timetables = $query->whereIn('subject_id', $subjectIds)->get();
        return view('timetables.display', compact('timetables'));
    }

    // === Parent ===
    if (Auth::user()->role === 'parents') {

        $parentInfo = ParentInfo::where('user_id', $userId)->first();

        if (!$parentInfo) {
            return redirect()->back()->withErrors('Parent info not found.');
        }


        $students = StudentList::where('parent_id', $parentInfo->id)->get();
        $studentIds = $students->pluck('id');


        $subjectIds = DB::table('enrollments')
            ->whereIn('student_id', $studentIds)
            ->distinct()
            ->pluck('subject_id');

        $timetables = $query->whereIn('subject_id', $subjectIds)->get();

        return view('timetables.display', compact('timetables', 'students', 'parentInfo'));
    }

    return redirect()->route('home')->with('error', 'No timetables found for your role.');
}


    public function download()
    {
        $filename = "timetable_report_" . now()->format('Ymd_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // Header row
            fputcsv($file, ['Subject Name', 'Price', 'Level', 'Class', 'Day', 'Start Time', 'End Time', 'Classroom']);

            Timetable::with('subject')->chunk(100, function ($timetables) use ($file) {
                foreach ($timetables as $t) {
                    fputcsv($file, [
                        $t->subject->name,
                        $t->subject->price,
                        $t->subject->level,
                        $t->subject->subject_class,
                        $t->day,
                        $t->start_time,
                        $t->end_time,
                        $t->classroom_name,
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function report(Request $request)
    {
        $level = $request->input('level');

        $query = Timetable::with('subject');
        if ($level) {
            $query->whereHas('subject', fn($q) => $q->where('level', $level));
        }

        $timetables = $query->get();
        return view('timetables.report', compact('timetables'));
    }
}
