<?php

namespace App\Http\Controllers\Roles\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Client;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    public function index()
    {
        return view('roles.staff.pages.client.list');
    }

    public function create()
    {
        return view('roles.staff.pages.client.create');
    }

    public function edit($id)
    {
        return view('roles.staff.pages.client.single' , ['client' => Client::findOrFail($id)]);
    }
}
