<?php

namespace App\Http\Controllers\Roles\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Department;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        return view('roles.staff.pages.project.list');
    }

    public function create()
    {
        return view('roles.staff.pages.project.create', ['users' => User::all()]);
    }

    public function show($id)
    {
        return view('roles.staff.pages.project.single', ['project' => Project::with(['venue', 'client', 'client_contact', 'project_owner', 'project_type', 'products', 'status', 'event', 'users'])->where('id', $id)->first(), 'user' => auth()->user()]);
    }

    public function user_projects($user_id) {
        return view('roles.staff.pages.project.user.list');
    }
}
