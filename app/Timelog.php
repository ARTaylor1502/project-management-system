<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    protected $table = 'task_timelogs';

    protected $fillable = ['task_id', 'user_id', 'notes', 'hours', 'minutes'];

    protected $appends = array('created_date_formatted', 'created_time_formatted');

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getCreatedDateFormattedAttribute()
    {
        return date('d/m/Y' , strtotime($this->created_at));
    }

    public function getCreatedTimeFormattedAttribute()
    {
        return date('H:i:s' , strtotime($this->created_at));
    }
}
