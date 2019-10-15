<?php

namespace App\Http\Controllers\API;

use App\ProjectArtwork;
use App\ProjectArtworkAmend;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Task;
use App\Project;
use App\ProjectType;
use App\ProjectStatus;
use App\User;
use App\ProjectAccommodation;
use App\ProjectTransport;
use App\ProjectLabour;
use App\ProjectArtworkAmendRequest;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\Controller;

class ProjectController extends Controller {

    public function index(Request $request) {
        if($request->all) {
            $projects = Project::with('event', 'client', 'status', 'project_type', 'tasks', 'users');
        } else if($request->count) {
            $projects = Project::count();
        } else {
            $query = Project::with(['event', 'client', 'status', 'project_type', 'users']);

            if($request->search) {
                $query->where('name', 'LIKE' , '%' . $request->search . '%');
            }

            if($request->status) {
                $query->where('status_id', $request->status);
            }

            if($request->event) {

                $event = $request->event;

                $query->whereHas('event', function($query) use ($event) {
                    $query->where('id', $event);
                });
            }

            if($request->user) {
                $user = $request->user;

                $query->whereHas('users', function($query) use ($user) {
                    $query->where('id', $user);
                });
            }

            if($request->order) {
                $order = $request->user;

                switch($order) {
                    case 'event_soonest' :
                        $query->whereHas('event', function($query) {
                            $query->orderBy('start_date', 'DESC');
                        });
                        break;
                    case 'project_last_updated' :
                        $query->orderBy('last_updated', 'DESC');
                        break;
                }
            }

            $projects = $query->paginate(15);
        }

        return response()->json($projects);
    }

    public function show($id) {
        return response()->json(Project::with(['venue', 'client', 'client_contact', 'project_owner', 'project_type', 'products', 'status', 'event', 'users'])->where('id', $id)->first());
    }

    public function department_tasks($project_id, $department_id) {
        $tasks = Task::where('project_id', $project_id)->where('department_id', $department_id)->orderBy('position_index', 'ASC')->with(['department', 'user'])->get();

        foreach($tasks as &$task) {
            $task->user->full_name = $task->user->full_name();
            $task->user->avatar_path = $task->user->avatar();
            $task->due_date_formatted = $task->dueDateFormatted('Y/m/d');
            $task->overdue = $task->overdue();
        }

        return response()->json($tasks);
    }

    public function update_tasks_order(Request $request) {
        foreach($request->tasks as $task) {
            Task::find($task['id'])->update(['position_index' => $task['position_index']]);
        }

        return response('Update successful', 200);
    }

    public function add_user(Request $request, $id) {
        $project = Project::find($id);

        $project->users()->attach($request->user_id);
        $project->save();

        return response()->json([
            'status'    => 'success',
            'message'   => 'User successfully added to project',
        ], 201);
    }

    public function remove_user(Request $request, $id) {
        $project = Project::find($id);

        if ($project->users->contains($request->user_id)) {
            $project->users()->detach($request->user_id);
            $project->save();

            return response()->json([
                'status'    => 'success',
                'message'   => 'User successfully removed from project',
            ], 201);
        } else {
            return response()->json([
                'status'    => 'error',
                'message'   => 'User doesn\'t exist on project',
            ], 201);
        }
    }

    public function available_users($id) {
        $users = User::whereDoesntHave('projects', function($q) use ($id){
            $q->where('id', $id);
        })->get();

        return response()->json($users);
    }

    public function department_users(Request $request, $project_id, $department_id) {
        $users = User::whereHas('projects', function($q) use ($project_id){
            $q->where('id', $project_id);
        })->where('department_id', $department_id)->get();

        return response()->json($users);
    }

    public function update(Request $request, $id) {
        $project = Project::find($id);

        foreach( $request->input() as $field => $value) {
            $project->$field = $value;
        }

        $project->save();

        return response()->json([
            'status' => 'success',
            'message'    => 'Project successfully updated',
        ], 201);
    }

    public function task_completion($project_id) {
        $tasks = Project::find($project_id)->tasks;
        $total_tasks = $tasks->count();
        $completed_tasks = $tasks->where('completed',1)->count();

        if($total_tasks > 0) {
            $completed_percentage = intval(($completed_tasks / $total_tasks) * 100);
        } else {
            $completed_percentage = 0;
        }

        $project_tasks['completed'] = $completed_tasks;
        $project_tasks['total'] =  $total_tasks;
        $project_tasks['completion_percentage'] = $completed_percentage;

        return response()->json($project_tasks);
    }

    public function task_time_spent($project_id) {
        $timelogs = DB::table('task_timelogs')
            ->join('tasks', 'task_timelogs.task_id', '=', 'tasks.id')
            ->select('task_timelogs.*')
            ->where('tasks.project_id', $project_id)
            ->whereNull('tasks.deleted_at')
            ->get();


        $timelog_data = array(
            'hours'     =>  0,
            'minutes'   =>  0
        );

        foreach($timelogs as $timelog) {
            $timelog_data['hours'] += $timelog->hours;
            $timelog_data['minutes'] += $timelog->minutes;
        }

        $timelog_data['hours'] += floor($timelog_data['minutes'] / 60);
        $timelog_data['minutes'] = $timelog_data['minutes'] % 60;

        return response()->json($timelog_data);
    }

    public function statuses() {
        return response()->json(ProjectStatus::all());
    }

    public function types() {
        return response()->json(ProjectType::orderBy('name','ASC')->get());
    }

    public function store(Request $request) {
        $project = new Project;

        $project->name = $request->name;
        $project->project_type_id = $request->project_type_id;
        $project->project_owner_id = $request->project_owner_id;
        $project->event_id = $request->event_id;
        $project->client_id = $request->client_id;
        $project->client_contact_id = $request->client_contact_id;
        $project->venue_id = $request->venue_id;
        $project->status_id = $request->status_id;
        $project->brief = $request->brief;

        $project->save();

        if($request->exists('products')) {
            foreach($request->products as $product) {
                $project->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            }
        }

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                $file->storeAs('projects/' . $project->id . '/files/',$file->getClientOriginalName());
            }
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Project successfully created',
            'project'   =>  $project
        ], 201);
    }

    public function all_project_artwork($project_id) {
        $project_artwork = ProjectArtwork::where(array('project_id' => $project_id))->with(array('artwork_type', 'amends',  'internalAmendRequests', 'internalAmendRequests.internal_requester', 'clientAmendRequests', 'clientAmendRequests.client_requester'))->get();

        return response()->json($project_artwork);
    }

    public function site_survey_artwork($project_id) {
        $project_artwork = ProjectArtwork::where(array('project_id' => $project_id, 'artwork_type_id' =>  DB::table('artwork_types')->where('name', 'Site Survey')->value('id')))->get();

        return response()->json($project_artwork);
    }

    public function concept_artwork($project_id) {
        $project_artwork = ProjectArtwork::where(array('project_id' => $project_id, 'artwork_type_id' =>  DB::table('artwork_types')->where('name', 'Design & Concept')->value('id'), 'ready_to_print' => 0))->get();

        return response()->json($project_artwork);
    }

    public function artwork($project_id) {
        $project_artwork = ProjectArtwork::where(array('project_id' => $project_id, 'artwork_type_id' =>  DB::table('artwork_types')->where('name', 'Artwork')->value('id'), 'ready_to_print' => 0))->get();

        return response()->json($project_artwork);
    }

    public function ready_to_print_artwork($project_id) {
        $print_artwork = ProjectArtwork::where(array('project_id' => $project_id, 'ready_to_print' => 1))->get();

        return response()->json($print_artwork);
    }

    public function store_artwork(Request $request, $id, $artwork_type) {
        if($request->artwork) {
            foreach($request->artwork as $artwork) {
                $new_artwork = new ProjectArtwork();

                $new_artwork->project_id = $id;
                $new_artwork->artwork_type_id =  DB::table('artwork_types')->where('name', $artwork_type)->value('id');
                $new_artwork->creator_id = $artwork['creator_id'];
                $new_artwork->name = $artwork['name'];
                $new_artwork->width = $artwork['width'];
                $new_artwork->height = $artwork['height'];
                $new_artwork->depth = $artwork['depth'];
                $new_artwork->description = $artwork['description'];

                if(array_key_exists('what3words_code', $artwork)) {
                    $new_artwork->what3words_code = $artwork['what3words_code'];
                } else if(array_key_exists('material', $artwork) && array_key_exists('print_code', $artwork)) {
                    $new_artwork->material = $artwork['material'];
                    $new_artwork->print_code = $artwork['print_code'];
                }

                $new_artwork->save();

                if($artwork['file'] && $new_artwork->id) {
                    ProjectArtwork::storeArtwork($new_artwork->id, $new_artwork->name, $artwork['file']);
                }
            }
        }

        return response()->json([
            'status'    => 'success',
            'message'   => $artwork_type . ' successfully uploaded'
        ], 201);
    }

    public function update_artwork(Request $request, $artwork_id) {
        $artwork = ProjectArtwork::find($artwork_id);

        foreach($request->input() as $field => $value) {
            $artwork->$field = $value;
        }

        $artwork->save();

        return response()->json([
            'status' => 'success',
            'message'    => 'Artwork successfully updated',
        ], 201);
    }

    public function update_amend(Request $request, $amend_id) {
        $amend = ProjectArtworkAmend::find($amend_id);

        foreach($request->input() as $field => $value) {
            $amend->$field = $value;
        }

        $amend->save();

        return response()->json([
            'status' => 'success',
            'message'    => 'Amend successfully updated',
        ], 201);
    }

    public function store_artwork_amend(Request $request, $artwork_id, $amend_request_id) {
        $new_artwork_amend = new ProjectArtworkAmend();

        $new_artwork_amend->project_artwork_id = $artwork_id;
        $new_artwork_amend->amend_request_id =  $amend_request_id;
        $new_artwork_amend->creator_id = $request->creator_id;
        $new_artwork_amend->name = $request->name;
        $new_artwork_amend->material = $request->material;
        $new_artwork_amend->print_code = $request->print_code;

        if($request->internally_approved && $request->internal_approver_id && $request->internally_approved_at) {
            $new_artwork_amend->internally_approved = $request->internally_approved;
            $new_artwork_amend->internal_approver_id = $request->internal_approver_id;
            $new_artwork_amend->internally_approved_at = $request->internally_approved_at;
        } else if($request->client_approved && $request->client_approver_id && $request->client_approved_at) {
            $new_artwork_amend->client_approved = $request->client_approved;
            $new_artwork_amend->client_approver_id = $request->client_approver_id;
            $new_artwork_amend->client_approved_at = $request->client_approved_at;
        }

        $new_artwork_amend->width = $request->width;
        $new_artwork_amend->height = $request->height;
        $new_artwork_amend->depth = $request->depth;
        $new_artwork_amend->description = $request->description;
        $new_artwork_amend->what3words_code = $request->what3words_code;

        $new_artwork_amend->save();

        if($request['file'] && $new_artwork_amend->id) {
            ProjectArtworkAmend::storeArtworkAmendFile($new_artwork_amend->id, $new_artwork_amend->name, $request['file']);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Artwork amend successfully added'
        ], 201);
    }

    public function store_artwork_amend_request(Request $request, $artwork_id) {
        $new_amend = new ProjectArtworkAmendRequest();

        $new_amend->artwork_id = $artwork_id;

        if($request->internal_requester_id) {
            $new_amend->internal_requester_id = $request->internal_requester_id;
        } else if($request->client_requester_id) {
            $new_amend->client_requester_id = $request->client_requester_id;
        }

        $new_amend->description = $request->description;

        $new_amend->save();

        if($request->file && $new_amend->id) {
            ProjectArtworkAmendRequest::storeAmendRequestFile($new_amend->id, $request->file('file'));
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Amend request successfully added'
        ], 201);
    }

    public function user_projects(Request $request, $user_id) {
        $user = User::findOrFail($user_id);

        if($request->all) {
            $projects = $user->projects()->with('event', 'client', 'status', 'project_type', 'tasks', 'users');
        } else if($request->count) {
            $projects = $user->projects()->count();
        } else if($request->limit) {
            $projects = $user->projects()->with('event', 'client', 'status', 'project_type', 'tasks', 'users')->limit(5)->get();
        } else {
            $query = $user->projects()->with(['event', 'client', 'status', 'project_type', 'tasks' => function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }]);

            if($request->search) {
                $query->where('name', 'LIKE' , '%' . $request->search . '%');
            }

            if($request->status) {
                $query->where('status_id', $request->status);
            }

            if($request->event) {
                $query->where('event_id', $request->event);
            }


            $projects = $query->paginate(15);
        }

        return response()->json($projects);
    }

    public function accommodation($project_id) {
        $accommodation = ProjectAccommodation::with('venue', 'venue.car_park_type')->where('project_id', $project_id)->get();

        return $accommodation;
    }

    public function store_accommodation(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'project_id'            => 'required|exists:projects,id',
            'venue_id'              => 'required|exists:venues,id',
            'number_of_rooms'       => 'required|numeric',
            'check_in'              => 'required|date',
            'check_out'             => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $project_accommodation = ProjectAccommodation::create($request->all());

        return response()->json([
            'status'                    =>  'success',
            'message'                   =>  'Project accommodation successfully created',
            'project_accommodation'     =>  $project_accommodation
        ], 201);
    }

    public function store_accommodation_attachments(Request $request, $accommodation_id) {
        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                ProjectAccommodation::storeAttachment($accommodation_id, $file->getClientOriginalName(), $file);
            }

            return response()->json([
                'status'                    =>  'success',
                'message'                   =>  'Attachments successfully added',
            ], 201);

        } else {
            return response()->json([
                'status'                    =>  'error',
                'message'                   =>  'No files supplied',
            ], 201);
        }
    }

    public function transport($project_id) {
        $transport = ProjectTransport::with('vehicle_type')->where('project_id', $project_id)->get();

        return $transport;
    }

    public function store_transport(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'project_id'            => 'required|exists:projects,id',
            'vehicle_type_id'       => 'required|exists:vehicle_types,id',
            'name'                  => 'required',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date',
            'rental_company'        => 'required',
            'license_plate'         => 'required',
            'colour'                => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $project_transport = ProjectTransport::create($request->all());

        return response()->json([
            'status'                    =>  'success',
            'message'                   =>  'Project transport successfully created',
            'project_transport'         =>  $project_transport
        ], 201);
    }

    public function vehicle_types() {
        return VehicleType::all();
    }

    public function labour($project_id) {
        $labour = ProjectLabour::with('user')->where('project_id', $project_id)->get();

        return $labour;
    }

    public function store_labour(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'project_id'            => 'required|exists:projects,id',
            'user_id'               => 'required|exists:users,id',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $project_labour = ProjectLabour::create($request->all());

        return response()->json([
            'status'                    =>  'success',
            'message'                   =>  'Project labour successfully created',
            'project_labour'            =>  $project_labour
        ], 201);
    }
}
