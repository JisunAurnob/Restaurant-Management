<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    //
    public function dashboard()
    {
        return view('dashboard');
    }
    public function profile()
    {
        return view('profile');
    }
    public function show_users($role)
    {
        $users = User::where('role', '=', $role)->get();
        return view('admin.tables.users_table', compact('users','role'));
    }
}
