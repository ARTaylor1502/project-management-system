<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectLabour extends Model
{
    protected $table = 'project_labour';

    protected $fillable = [
        'project_id', 'user_id', 'responsibilities', 'start_date', 'end_date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
