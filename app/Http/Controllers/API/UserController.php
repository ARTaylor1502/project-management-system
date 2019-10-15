<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use App\UserTitle;
use App\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->all) {
            $users = User::with(['role', 'title'])->get();
        } else {
            $query = User::with(['role', 'title']);

            if($request->search) {
                $query->where('first_name', 'LIKE' , '%' . $request->search . '%')->orWhere('last_name', 'LIKE' , '%' . $request->search . '%');
            }

            if($request->filter) {
                switch($request->filter) {
                    case 'staff' :
                        $query->where('role_id', UserRole::where('name', 'Staff')->first()->id);
                        break;
                    case 'client' :
                        $query->where('role_id', UserRole::where('name', 'Client')->first()->id);
                        break;
                    case 'contractor' :
                        $query->where('role_id', UserRole::where('name', 'Contractor')->first()->id);
                        break;
                    case 'supplier' :
                        $query->where('role_id', UserRole::where('name', 'Supplier')->first()->id);
                        break;
                }
            }

            if($request->order) {
                $order_params = explode('_', $request->order);

                if(count($order_params) === 2) {
                    list($order_by_name, $order_by_direction) = $order_params;

                    $order_by_name = str_replace('-', '_', $order_by_name);

                    $query->orderBy($order_by_name, $order_by_direction);
                }
            }

            $users = $query->paginate(15);
        }

        return response()->json($users);
    }

    public function show($id) {
        return response()->json(User::with(['role', 'title', 'addresses', 'activeTasks', 'completedTasks', 'artworkApproved'])->where('id', $id)->first());
    }

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'first_name'            => 'required|max:255',
            'last_name'             => 'required|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|max:16',
            'landline_tele'         => 'required|max:11',
            'mobile_tele'           => 'max:11',
            'title_id'              => 'required|exists:user_titles,id',
            'role_id'               => 'required|exists:user_roles,id',
            'department_id'         => 'exists:departments,id',
            'avatar'                => 'file|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $user = new User;

        $user->title_id = $request->title_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->landline_tele = $request->landline_tele;
        $user->mobile_tele = $request->mobile_tele;

        $user->save();


        if($request->addresses) {
            foreach($request->addresses as $address) {
                $user_address = new UserAddress();

                $address = json_decode($address);

                $user_address->user_id = $user->id;
                $user_address->address_name = $address->address_name;
                $user_address->is_primary_address = $address->is_primary_address;
                $user_address->address_first_line = $address->address_first_line;
                $user_address->address_second_line = $address->address_second_line;
                $user_address->address_town = $address->address_town;
                $user_address->address_county = $address->address_county;
                $user_address->address_postcode = $address->address_postcode;
                $user_address->what3words_code = $address->what3words_code;

                $user_address->save();
            }
        }

        if($request->avatar) {
            Storage::deleteDirectory('users/'.$user->id.'/assets/avatar');
            $request->avatar->storeAs('users/' . $user->id . '/assets/', '/avatar/avatar.' . $request->avatar->extension());
        }

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'User successfully created',
            'user'    =>  $user
        ], 201);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make(
            $request->all(), [
            'department_id'         =>  'exists:departments,id',
            'role_id'               =>  'required|exists:user_roles,id',
            'title_id'              =>  'required|exists:user_titles,id',
            'first_name'            =>  'required|max:255',
            'last_name'             =>  'required|max:255',
            'landline_tele'         =>  'required|max:11',
            'mobile_tele'           =>  'required|max:11'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        User::where('id', $id)->update($request->all());

        return response()->json([
            'status'    => 'success',
            'message'   => 'User successfully updated',
        ], 201);
    }

    public function store_address(Request $request, $user_id) {
        $merged_request_data = array_merge(array('user_id' => $user_id), $request->all());

        $validator = Validator::make(
            $merged_request_data, [
            'user_id'               => 'required|exists:users,id',
            'address_name'          => 'required|max:255',
            'address_first_line'    => 'required|max:255',
            'address_second_line'   => 'max:255',
            'address_town'          => 'required|max:255',
            'address_county'        => 'max:255',
            'address_postcode'      => 'required|max:255',
            'what3words_code'       => 'max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        if($request->is_primary_address === true) {
            UserAddress::where('user_id', $user_id)->update(['is_primary_address' => 0]);
        }

        UserAddress::create($merged_request_data);

        return response()->json([
            'status'    => 'success',
            'message'   => 'User address successfully created',
        ], 201);
    }

    public function update_address(Request $request, $user_id, $address_id) {
        $validator = Validator::make(
            $request->all(), [
            'address_name'          => 'required|max:255',
            'address_first_line'    => 'required|max:255',
            'address_second_line'   => 'max:255',
            'address_town'          => 'required|max:255',
            'address_county'        => 'max:255',
            'address_postcode'      => 'required|max:255',
            'what3words_code'       => 'max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        if($request->is_primary_address === true) {
            UserAddress::where('user_id', $user_id)->update(['is_primary_address' => 0]);
        }

        UserAddress::where('id', $address_id)->update([
            'address_name'          => $request->address_name,
            'is_primary_address'    => $request->is_primary_address,
            'address_first_line'    => $request->address_first_line,
            'address_second_line'   => $request->address_second_line,
            'address_town'          => $request->address_town,
            'address_county'        => $request->address_county,
            'address_postcode'      => $request->address_postcode,
            'what3words_code'       => $request->what3words_code
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'User address successfully updated',
        ], 201);
    }

    public function titles() {
        return response()->json(UserTitle::all());
    }

    public function roles() {
        return response()->json(UserRole::all());
    }

    public function events($user_id) {
        $user = User::findOrFail($user_id);

        return response()->json($user->events());
    }

    public function avatar($user_id) {
        $user = User::findOrFail($user_id);

        return response()->json($user->avatar());
    }

    public function staff() {
        return response()->json(User::staff()->get());
    }

    public function search(Request $request) {
        $users =  DB::table('users')->where('first_name', 'LIKE', '%' . $request->query_string . '%')->orWhere('last_name', 'LIKE', '%' . $request->query_string . '%')->get();

        return response()->json($users);
    }
}
