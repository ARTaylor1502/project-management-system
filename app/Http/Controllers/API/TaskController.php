<?php

namespace App\Http\Controllers\API;

use App\CustomTaskCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Task;
use App\Subtask;
use App\Timelog;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller {

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'name'              => 'required|max:255',
            'project_id'        => 'required|exists:projects,id',
            'department_id'     => 'required|exists:departments,id',
            'user_id'           => 'required|exists:users,id',
            'position_index'    => 'required|integer',
            'start_date'        => 'required|date|before:due_date',
            'due_date'          => 'required|date|after:start_date',
            'quote_required'    => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $task = Task::create($request->all());

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Task successfully created',
            'task'      =>  $task
        ], 201);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make(
            $request->all(), [
            'project_id'            =>  'exists:projects,id',
            'department_id'         =>  'exists:departments,id',
            'user_id'               =>  'exists:users,id',
            'name'                  =>  'max:255',
            'start_date'            =>  'date|before:due_date',
            'due_date'              =>  'date|after:start_date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        Task::where('id', $id)->update($request->all());

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                $file->storeAs('tasks/' . $id . '/files/',$file->getClientOriginalName());
            }
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Task successfully updated',
        ], 201);
    }

    public function add_files(Request $request, $id) {
        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                Task::storeFiles($id, $file->getClientOriginalName(), $file);
            }
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Files successfully added',
        ], 201);
    }

    public function mark_complete(Request $request) {
        Task::find($request->task_id)->update(['completed' => 1, 'completed_date' => date('Y/m/d H:i:s')]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Task successfully marked complete',
        ], 201);
    }

    public function update_tasks_order(Request $request) {
        foreach($request->tasks as $task) {
            Task::find($task['id'])->update(['position_index' => $task['position_index']]);
        }

        return response('Update successful', 200);
    }

    public function user_tasks(Request $request, $user_id) {
        $query = Task::with(['user', 'project', 'project.client'])->where('user_id', $user_id)->orderBy('due_date', 'ASC');

        if($request->completed) {
            $query->where( 'completed', 1);
        }

        if($request->active) {
            $query->where( 'completed', 0);
        }

        if($request->completed_date) {
            $query->where( 'completed_date', '>=', $request->completed_date);
        }

        if($request->count) {
            $tasks = $query->count();
        } else {
            if($request->items_per_page) {
                $tasks = $query->paginate($request->items_per_page);
            } else {
                $tasks = $query->paginate(15);
            }
        }

        return response()->json($tasks);
    }

    public function project_department_task_categories(Request $request, $project_id) {
        $departments = DB::table('departments')->get();

        foreach($departments as &$department) {
            $template_categories = DB::table('tasks')
                ->join('task_categories', 'task_categories.id', '=', 'tasks.task_category_id')
                ->selectRaw('task_categories.id AS category_id, task_categories.name')
                ->where('tasks.project_id', $project_id)
                ->where('tasks.department_id', $department->id)
                ->whereNull('tasks.deleted_at')
                ->distinct()
                ->get();

            $custom_categories =  DB::table('project_custom_task_categories')
                ->selectRaw('id AS custom_category_id, name')
                ->where('project_id', $project_id)
                ->where('department_id', $department->id)
                ->distinct()
                ->get();

            $department->task_categories = $template_categories->merge($custom_categories);
        }

        return response()->json($departments);
    }

    public function project_department_task(Request $request, $project_id) {
        $departments = DB::table('departments')->get();

        foreach($departments as &$department) {
            $department->task_categories = DB::table('tasks')
                ->join('task_categories', 'task_categories.id', '=', 'tasks.task_category_id')
                ->select('task_categories.*')
                ->where('tasks.project_id', $project_id)
                ->where('tasks.department_id', $department->id)
                ->whereNull('tasks.deleted_at')
                ->distinct()
                ->get();
        }

        return response()->json($departments);
    }

    public function project_department_tasks(Request $request, $project_id, $department_id) {
        $tasks = Task::with(['user', 'project', 'project.client', 'task_category'])->where(['project_id' => $project_id, 'department_id' => $department_id])->orderBy('position_index', 'ASC')->get();

        return response()->json($tasks);
    }

    public function project_task_category_tasks(Request $request, $project_id, $task_category_id) {
        $tasks = Task::with(['user', 'project', 'project.client', 'task_category'])->where(['project_id' => $project_id, 'task_category_id' => $task_category_id])->orderBy('position_index', 'ASC')->get();

        return response()->json($tasks);
    }

    public function project_custom_task_category_tasks(Request $request, $project_id, $custom_task_category_id) {
        $tasks = Task::with(['user', 'project', 'project.client', 'task_category'])->where(['project_id' => $project_id, 'custom_task_category_id' => $custom_task_category_id])->orderBy('position_index', 'ASC')->get();

        return response()->json($tasks);
    }

    public function subtasks($task_id) {
        $subtasks = Subtask::where('task_id', $task_id)->orderBy('position_index', 'ASC')->get();

        return response()->json($subtasks);
    }

    public function store_subtask(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'task_id'     => 'required|exists:tasks,id',
            'user_id'     => 'required|exists:users,id',
            'name'        => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $subtask = Subtask::create($request->all());

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Subtask successfully created',
            'subtask'   =>  $subtask
        ], 201);
    }

    public function mark_subtask_complete(Request $request) {
        Subtask::find($request->subtask_id)->update(['completed' => 1, 'completed_date' => date('Y/m/d')]);

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Update successful',
        ], 201);
    }

    public function timelogs($task_id) {
        $timelogs = Timelog::with('user')->where('task_id', $task_id)->orderBy('created_at', 'DESC')->get();

        return response()->json($timelogs);
    }

    public function store_timelog(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'task_id'     => 'required|exists:tasks,id',
            'user_id'     => 'required|exists:users,id',
            'notes'       => 'required',
            'hours'       => 'required|numeric',
            'minutes'     => 'required|digits_between:0,59',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $timelog = Timelog::create($request->all());

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Timelog successfully created',
            'timelog'   =>  $timelog
        ], 201);
    }

    public function delete(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'task_id'     => 'required|exists:tasks,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        Task::where('id', $request->task_id)->delete();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Task successfully deleted'
        ], 201);
    }

    public function store_project_task_category(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'project_id'        => 'required|exists:projects,id',
            'department_id'     => 'required|exists:departments,id',
            'name'              => 'required|unique',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $category = CustomTaskCategory::create($request->all());

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Tasklist category successfully created',
            'category'   =>  $category
        ], 201);
    }
}
