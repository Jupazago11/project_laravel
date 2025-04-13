<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('superadmin.dashboard', compact('user'));
    }
}
