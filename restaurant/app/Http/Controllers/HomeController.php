<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function change_pass()
    {
        return view('auth.passwords.change');
    }

    public function change_pass_post(Request $request)
    {
        $this->validate(
            $request,
            [
                'currentpass' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            []
        );
        // if ((User::where('email', '=', $request->email)->exists()) && User::where('password', '=', Hash::make($request->currentpass))->exists()) {
        if(Hash::check($request->currentpass, auth()->user()->password)){
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('login');
        }
        // 
        $currentpass = 'Current Password Is Incorrect!';
        return view('auth.passwords.change', compact('currentpass'));
    }
}
