<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    public $fillable = [
        'name', 'address_first_line', 'address_second_line', 'address_town', 'address_county', 'address_postcode', 'what3words_code'
    ];

    public function car_park_type()
    {
        return $this->belongsTo('App\CarParkType', 'car_park_type_id', 'id');
    }
}
