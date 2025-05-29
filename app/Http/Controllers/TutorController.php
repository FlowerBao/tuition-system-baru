<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\User;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Tutor::with('subject');

    // Filter by subject level if selected
    if ($request->filled('level_filter')) {
        $query->whereHas('subject', function ($q) use ($request) {
            $q->where('level', $request->level_filter);
        });
    }

    $tutorList = $query->paginate(10);

    return view('tutors.index', compact('tutorList'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get subject IDs already taken by tutors
        $assignedSubjectIds = Tutor::pluck('subject_id')->toArray();
    
        // Get all subjects
        $subjects = Subject::all();
    
        return view('tutors.create', compact('subjects', 'assignedSubjectIds'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'tutor_name' => 'required|string|max:255',
            'tutor_ic' => 'required|string',
            'tutor_email' => 'required|email|unique:tutors,tutor_email|unique:users,email',
            'tutor_phone' => 'required|string',
            'tutor_address' => 'nullable|string',
            'password' => 'required|min:8',
            'subject_id' => 'required|exists:subjects,id', // Ensure the subject_id exists in the subjects table
        ]);
    
        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::create([
                    'name' => $validatedData['tutor_name'],
                    'email' => $validatedData['tutor_email'],
                    'password' => Hash::make($validatedData['password']),
                    'role' => 'tutor'
                ]);
    
                $tutor = Tutor::create([
                    'user_id' => $user->id,
                    'subject_id' => $validatedData['subject_id'], // Assign the subject
                    'tutor_name' => $validatedData['tutor_name'],
                    'tutor_ic' => $validatedData['tutor_ic'],
                    'tutor_email' => $validatedData['tutor_email'],
                    'tutor_phone' => $validatedData['tutor_phone'],
                    'tutor_address' => $validatedData['tutor_address'] ?? null,
                ]);

            });
    
            return redirect()->route('tutors.index')->with('success', 'Tutor registered successfully');
        } catch (\Exception $e) {
            \Log::error('Error registering tutor: ' . $e->getMessage());
            return back()->with('error', 'Error registering tutor. Check logs for details' . $e->getMessage())->withInput();
        }
    }

        

        

    /**
     * Display the specified resource.
     */
    public function show(Tutor $tutor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $tutor = Tutor::findOrFail($id);
    $subjects = Subject::all(); // You might already be doing this

    return view('tutors.edit', compact('tutor', 'subjects'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tutor $tutor)
    {
        //
        $validatedData = $request->validate([
            'tutor_name' => 'required|string|max:255',
            'tutor_ic' => 'required|string',
            'tutor_email' => 'required|email|unique:tutors,tutor_email,' . $tutor->id . '|unique:users,email,' . $tutor->user_id,
            'tutor_phone' => 'required|string',
            'tutor_address' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id', // Validate subject_id
        ]);
    
        try {
            DB::transaction(function () use ($validatedData, $tutor) {
                $tutor->update([
                    'tutor_name' => $validatedData['tutor_name'],
                    'tutor_ic' => $validatedData['tutor_ic'],
                    'tutor_email' => $validatedData['tutor_email'],
                    'tutor_phone' => $validatedData['tutor_phone'],
                    'tutor_address' => $validatedData['tutor_address'] ?? null,
                    'subject_id' => $validatedData['subject_id'], // Update assigned subject
                ]);
    
                $tutor->user->update([
                    'name' => $validatedData['tutor_name'],
                    'email' => $validatedData['tutor_email'],
                ]);
            });
    
            return redirect()->route('tutors.index')->with('success', 'Tutor updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating tutor: ' . $e->getMessage());
            return back()->with('error', 'Error updating tutor. Check logs for details.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tutor $tutor)
    {
        //
        $tutor->delete(); // equivalent to delete from table_name where id="";
        return redirect()->back()->with('message', 'Tutor deleted successfully');
    }
    
}
