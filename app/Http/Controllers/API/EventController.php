<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Event;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class EventController extends Controller {

    public function index(Request $request) {
        if($request->all) {
            $events = Event::with(['venue'])->get();
        } else {
            $query = Event::with('venue');

            if($request->search) {
                $query->where('name', 'LIKE' , '%' . $request->search . '%');
            }

            if($request->filter) {
                switch($request->filter) {
                    case 'active' :
                        $query->where('end_date', '>' , now());
                        break;
                    case 'inactive' :
                        $query->where('end_date', '<=' , now());
                        break;
                }
            }

            if($request->order) {
                $order_params = explode('_', $request->order);

                if(count($order_params) === 2) {
                    list($order_by_name, $order_by_direction) = $order_params;
                    $query->orderBy($order_by_name, $order_by_direction);
                }
            }

            $events = $query->paginate(15);
        }

        return response()->json($events);
    }

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'name'                  => 'required|max:255',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        Event::create($request->all());

        return response()->json([
            'status' => 'success',
            'message'    => 'Event successfully created',
        ], 201);
    }
}
