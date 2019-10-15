<?php

namespace App\Http\Controllers\API;

use App\Venue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VenueController extends Controller
{
    public function index() {
        return response()->json(Venue::orderBy('name','ASC')->get());
    }

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'name'                      => 'required|max:255',
            'address_first_line'        => 'required|max:255',
            'address_second_line'       => 'max:255',
            'address_town'              => 'required|max:255',
            'address_county'            => 'max:255',
            'address_postcode'          => 'required|max:11',
            'what3words_code'           => 'required|max:255',
            'landline_tele'             => 'required|max:11',
            'car_park_type_id'          => 'required|exists:car_park_types,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        Venue::create($request->all());

        return response()->json([
            'status' => 'success',
            'message'    => 'Venue successfully created'
        ], 201);
    }

    public function search(Request $request) {
        $venues =  DB::table('venues')->leftJoin('car_park_types', 'venues.car_park_type_id', '=' ,'car_park_types.id')->select(DB::raw('venues.*, car_park_types.name AS car_park_type'))->where('venues.name', 'LIKE', '%' . $request->query_string . '%')->get();

        return response()->json($venues);
    }

    public function car_park_types() {
        $car_park_types = DB::table('car_park_types')->get();

        return response()->json($car_park_types);
    }
}
