<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Client;
use App\ClientContact;
use App\Project;
use App\ClientType;
use App\ClientAddress;
use App\ClientPassword;
use App\Helper\Encryption;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Http\Controllers\Controller;

class ClientController extends Controller {

    public function index(Request $request) {
        if($request->all) {
            $clients = Client::with(['contacts'])->get();
        } else {
            if($request->search) {
                $clients = Client::with(['contacts'])->where('name', 'LIKE' , '%' . $request->search . '%')->orderBy('name',$request->order)->paginate(15);
            } else {
                $clients = Client::with('contacts')->orderBy('name',$request->order)->paginate(15);
            }
        }

        return response()->json($clients);
    }

    public function show($id) {
        return response()->json(Client::with(['aliases', 'addresses', 'contacts', 'passwords', 'projects','projects.status', 'projects.client_contact', 'projects.event', 'projects.venue', 'projects.project_owner', 'projects.project_owner.department'])->where('id', $id)->first());
    }

    public function contacts($client_id) {
        $client = Client::find($client_id);

        return response()->json($client->contacts);
    }

    public function projects($client_id) {
        $projects = Project::where('client_id', $client_id)->with(['event', 'client', 'status', 'project_type', 'users'])->get();

        return response()->json($projects);
    }

    public function types() {
        return response()->json(ClientType::all());
    }

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'name'                  => 'required|max:255',
            'landline_tele'         => 'required|max:11',
            'mobile_number'         => 'max:11',
            'company_colour'        => 'required|max:11',
            'website'               => 'max:255',
            'account_manager_id'    => 'required|exists:users,id',
            'client_type_id'        => 'required|exists:client_types,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $client = new Client;

        $client->name = $request->name;
        $client->landline_tele = $request->landline_tele;
        $client->mobile_number = $request->mobile_number;
        $client->company_colour = $request->company_colour;
        $client->website = $request->website;
        $client->account_manager_id = $request->account_manager_id;
        $client->client_type_id = $request->client_type_id;
        $client->private_notes = $request->private_notes;

        $client->save();

        if($request->contacts) {
            foreach($request->contacts as $contact) {
                $client_contact = new ClientContact();

                $contact = json_decode($contact);

                $client_contact->client_id = $client->id;
                $client_contact->is_primary_contact = $contact->is_primary_contact;
                $client_contact->first_name = $contact->first_name;
                $client_contact->last_name = $contact->last_name;
                $client_contact->email = $contact->email;
                $client_contact->landline_tele = $contact->landline_tele;
                $client_contact->mobile_number = $contact->mobile_number;

                $client_contact->save();
            }
        }

        if($request->addresses) {
            foreach($request->addresses as $address) {
                $client_address = new ClientAddress();

                $address = json_decode($address);

                $client_address->client_id = $client->id;
                $client_address->address_name = $address->address_name;
                $client_address->is_primary_address = $address->is_primary_address;
                $client_address->address_first_line = $address->address_first_line;
                $client_address->address_second_line = $address->address_second_line;
                $client_address->address_town = $address->address_town;
                $client_address->address_county = $address->address_county;
                $client_address->address_postcode = $address->address_postcode;
                $client_address->what3words_code = $address->what3words_code;

                $client_address->save();
            }
        }

        if($request->logo) {
            Storage::deleteDirectory('clients/'.$client->id.'/assets/logo');
            $request->logo->storeAs('clients/' . $client->id . '/assets/', '/logo/logo.' . $request->logo->extension());
        }

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Client successfully created',
            'client'    =>  $client
        ], 201);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make(
            $request->all(), [
            'name'                  =>  'required|max:255',
            'landline_tele'         =>  'required|max:11',
            'mobile_number'         =>  'required|max:11',
            'website'               =>  'required|max:255',
            'company_colour'        =>  'required|max:255',
            'account_manager_id'    =>  'required|exists:users,id',
            'client_type_id'        =>  'required|exists:client_types,id',
            'private_notes'         =>  'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        Client::where('id', $id)->update($request->all());

        return response()->json([
            'status' => 'success',
            'message'    => 'Client successfully updated',
        ], 201);
    }

    public function store_address(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'client_id'             => 'required|exists:clients,id',
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
            ClientAddress::where('client_id', $request->client_id)->update(['is_primary_address' => 0]);
        }

        ClientAddress::create($request->all());

        return response()->json([
            'status'        => 'success',
            'message'       => 'Client address successfully created',
        ], 201);
    }

    public function update_address(Request $request, $client_id, $address_id) {
        $validator = Validator::make(
            $request->all(), [
            'client_id'             => 'required|exists:clients,id',
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
            ClientAddress::where('client_id', $client_id)->update(['is_primary_address' => 0]);
        }

        ClientAddress::where('id', $address_id)->update([
            'is_primary_address'    => $request->is_primary_address,
            'address_name'          => $request->address_name,
            'address_first_line'    => $request->address_first_line,
            'address_second_line'   => $request->address_second_line,
            'address_town'          => $request->address_town,
            'address_county'        => $request->address_county,
            'address_postcode'      => $request->address_postcode,
            'what3words_code'       => $request->what3words_code
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Client address successfully updated',
        ], 201);
    }

    public function store_contact(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'client_id'             => 'required|exists:clients,id',
            'first_name'            => 'required|max:255',
            'last_name'             => 'required|max:255',
            'email'                 => 'required|email|unique:client_contacts',
            'is_primary_contact'    => 'required|boolean',
            'landline_tele'         => 'max:11',
            'mobile_number'         => 'max:11'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        if($request->is_primary_contact === true) {
            ClientContact::where('client_id', $request->client_id)->update(['is_primary_contact' => 0]);
        }

        ClientContact::create($request->all());

        return response()->json([
            'status' => 'success',
            'message'    => 'Client contact successfully created',
        ], 201);
    }

    public function update_contact(Request $request, $client_id, $client_contact_id) {
        $validator = Validator::make(
            $request->all(), [
            'client_id'             => 'required|exists:clients,id',
            'first_name'            => 'required|max:255',
            'last_name'             => 'required|max:255',
            'is_primary_contact'    => 'required|boolean',
            'landline_tele'         => 'max:11',
            'mobile_number'         => 'max:11'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        if($request->is_primary_contact === true) {
            ClientContact::where('client_id', $client_id)->update(['is_primary_contact' => 0]);
        }

        ClientContact::where('id', $client_contact_id)->update([
            'is_primary_contact'    => $request->is_primary_contact,
            'first_name'            => $request->first_name,
            'last_name'             => $request->last_name,
            'landline_tele'         => $request->landline_tele,
            'mobile_number'         => $request->mobile_number,
        ]);

        return response()->json([
            'status' => 'success',
            'message'    => 'Client contact successfully updated',
        ], 201);
    }

    public function store_password(Request $request, $client_id) {
        $encryption = new Encryption();

        $validator = Validator::make(
            $request->all(), [
            'name'        => 'required|max:255',
            'url'         => 'required|max:255',
            'details'     => 'required|max:255',
            'password'    => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $add_array = array(
            'client_id'       => $request->client_id,
            'name'            => $request->name,
            'url'             => $request->url,
            'details'         => $request->details,
            'password'        => $encryption->encrypt($request->password)
        );

        ClientPassword::create($add_array);

        return response()->json([
            'status' => 'success',
            'message'    => 'Client password successfully created',
        ], 201);
    }

    public function delete_password(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'password_id'             => 'required|exists:client_passwords,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        ClientPassword::where('id', $request->password_id)->delete();

        return response()->json([
            'status' => 'success',
            'message'    => 'Client password successfully deleted',
        ], 201);
    }

    public function update_password(Request $request, $id) {
        $encryption = new Encryption();

        $validator = Validator::make(
            $request->all(), [
            'name'            => 'required|max:255',
            'url'             => 'required|max:255',
            'details'         => 'required|max:255',
            'password'        => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        $existing_client_password = ClientPassword::where('id', $id)->first();

        $update_array = array(
            'name'            => $request->name,
            'url'             => $request->url,
            'details'         => $request->details,
        );

        if($encryption->decrypt($existing_client_password->password) !== $request->password) {
            $update_array['password'] = $encryption->encrypt($request->password);
        }

        ClientPassword::where('id', $id)->update($update_array);

        return response()->json([
            'status'        => 'success',
            'message'       => 'Client password successfully updated',
        ], 201);
    }
}
