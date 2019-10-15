<?php


namespace App\Http\Controllers\API;


class AddressController {
    public function lookup($postcode) {
        $data=file_get_contents('https://api.formation.software/'.config('app.get_address_api_key').'/address/'.$postcode);

        echo $data;
    }
}