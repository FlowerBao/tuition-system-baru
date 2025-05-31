<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentInfoController extends Controller
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
        //
        $user = auth()->user(); // Get the authenticated user
        return view('parents.create', compact('user')); // Pass the user to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'parent_name' => 'required|string|max:255',
        'parent_ic' => 'required|string',
        'parent_email' => 'required|email|unique:staff|unique:users,email',
        'parent_phone' => 'required|string',
        'parent_address' => 'nullable|string',
        'password' => 'required|min:8'
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name' => $validatedData['parent_name'],
                'email' => $validatedData['parent_email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'parents'
            ]);

            ParentInfo::create([
                'user_id' => $user->id,
                'parent_name' => $validatedData['parent_name'],
                'parent_ic' => $validatedData['parent_ic'],
                'parent_email' => $validatedData['parent_email'],
                'parent_phone' => $validatedData['parent_phone'],
                'parent_address' => $validatedData['parent_address'] ?? null,
            ]);
        });

        return redirect()->route('parents.create')->with('success', 'Parent registered successfully');
    } catch (\Exception $e) {
        return back()->with('error', 'Error registering parent: ' . $e->getMessage())->withInput();
    }
}


    /**
     * Display the specified resource.
     */
    public function show(ParentInfo $parentInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentInfo $parentInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentInfo $parentInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentInfo $parentInfo)
    {
        //
    }
}
