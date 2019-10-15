<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $table = 'task_subtasks';

    protected $fillable = [
        'task_id', 'user_id', 'name', 'position_index', 'completed', 'completed_date'
    ];
}
