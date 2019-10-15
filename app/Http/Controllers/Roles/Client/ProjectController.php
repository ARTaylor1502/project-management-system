<?php

namespace App\Http\Controllers\Roles\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Department;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('roles.client.pages.project.list', ['user' => auth()->user()]);
    }

    public function show($id)
    {
        return view('roles.client.pages.project.single', ['project' => Project::findOrFail($id), 'user' => auth()->user()]);
    }
}
