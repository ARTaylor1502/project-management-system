<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function index() {
        if (Auth::guard('staff')->check()) {
            Auth::logout();
            Session::flush();
            return redirect(route('staff.login'));
        } else {
            Auth::logout();
            Session::flush();
            return redirect(route('login'));
        }
    }
}
