<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomTaskCategory extends Model
{
    protected $table = 'project_custom_task_categories';

    protected $fillable = [
        'project_id', 'department_id', 'name'
    ];
}
