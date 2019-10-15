<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    protected $fillable = [
        'client_id', 'first_name', 'last_name', 'email', 'is_primary_contact', 'landline_tele', 'mobile_number'
    ];

    protected $appends = array('full_name');

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
