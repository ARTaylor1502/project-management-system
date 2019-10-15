<?php

namespace App\Http\Controllers\Roles\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\User;
use \App\Department;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        return view('roles.staff.pages.user.list');
    }

    public function create()
    {
        return view('roles.staff.pages.user.create');
    }

    public function edit($id)
    {
        return view('roles.staff.pages.user.single', ['user' => User::findOrFail($id)]);
    }
}
