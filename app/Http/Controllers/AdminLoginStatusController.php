<?php
// app/Http/Controllers/AdminLoginStatusController.php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;

class AdminLoginStatusController extends Controller
{
    public function index()
    {
        $logins = Login::with('user')
            ->orderBy('logged_in_at', 'desc')
            ->paginate(20);

        return view('admins.login-status', compact('logins'));
    }
}
