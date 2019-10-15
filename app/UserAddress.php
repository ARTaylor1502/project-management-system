<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'address_name', 'is_primary_address', 'address_first_line', 'address_second_line', 'address_town', 'address_county', 'address_postcode', 'what3words_code'
    ];
}
