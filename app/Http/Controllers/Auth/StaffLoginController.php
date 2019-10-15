<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class StaffLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:staff');
    }

    public function showLoginForm()
    {
        return view('auth.staff-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     =>  'required|email',
            'password'  => 'required|min:6'
        ]);

        if(Auth::guard('staff')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('staff.dashboard'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}