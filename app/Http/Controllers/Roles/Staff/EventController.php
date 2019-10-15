<?php

namespace App\Http\Controllers\Roles\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        return view('roles.staff.pages.event.list');
    }
}
