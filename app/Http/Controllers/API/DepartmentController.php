<?php

namespace App\Http\Controllers\API;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index() {
        return response()->json(Department::all());
    }
}
