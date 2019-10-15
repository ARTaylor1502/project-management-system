<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    protected $fillable = [
        'user_id', 'start_date', 'end_date', 'notes'
    ];
}
