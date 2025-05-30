<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentList;
use App\Models\Subject;
use App\Models\Tutor;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $totalStudents = StudentList::count();
            $totalTutors = User::where('role', 'tutor')->count();
            $totalSubjects = Subject::count();

            return view('dashboard', compact('totalStudents', 'totalTutors', 'totalSubjects'));
        }

        if ($user->role === 'tutor') {
            // Get subject IDs assigned to this tutor
            $subjectIds = Tutor::where('user_id', $user->id)->pluck('subject_id');

            // Use the updated many-to-many relationship to count students per subject
            $subjectsWithCounts = Subject::whereIn('id', $subjectIds)
                ->withCount('students') // uses belongsToMany via enrollments table
                ->get();

            return view('dashboard', compact('subjectsWithCounts'));
        }

        if ($user->role === 'parents') {
            $parentInfo = $user->parentInfo;

            $totalParentStudents = 0;
            if ($parentInfo) {
                $totalParentStudents = StudentList::where('parent_id', $parentInfo->id)->count();
            }

            return view('dashboard', compact('totalParentStudents'));
        }

        return view('dashboard');
    }
}
