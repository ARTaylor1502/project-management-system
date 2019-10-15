<?php

namespace App;

use App\Helper\Storage as StorageHelper;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Date as DateHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'department_id', 'task_category_id', 'custom_task_category_id', 'user_id', 'name', 'position_index', 'due_date', 'start_date', 'notes', 'completed', 'completed_date', 'quote_required'
    ];

    protected $appends = array('due_date_formatted', 'due_date_html_formatted', 'due_time_formatted', 'start_date_formatted', 'start_date_html_formatted', 'start_time_formatted', 'files');

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function task_category()
    {
        return $this->hasOne('App\TaskCategory', 'id', 'task_category_id');
    }

    public function timelogs() {
        return $this->hasMany('App\Timelog', 'task_id', 'id');
    }

    public function due_date_formatted($format)
    {
        return date($format, strtotime($this->due_date));
    }

    public function getDueDateFormattedAttribute()
    {
        return date('d/m/Y' , strtotime($this->due_date));
    }

    public function getDueDateHtmlFormattedAttribute()
    {
        return date('Y-m-d' , strtotime($this->due_date));
    }

    public function getDueTimeFormattedAttribute()
    {
        return date('H:i:s' , strtotime($this->due_date));
    }

    public function getStartDateFormattedAttribute()
    {
        return date('d/m/Y' , strtotime($this->start_date));
    }

    public function getStartDateHtmlFormattedAttribute()
    {
        return date('Y-m-d' , strtotime($this->start_date));
    }

    public function getStartTimeFormattedAttribute()
    {
        return date('H:i:s' , strtotime($this->start_date));
    }

    public function overdue()
    {
        return DateHelper::isPastDate($this->due_date);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('completed', 0);
    }

    public function getFilesAttribute() {
        $task_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('tasks/'.$task_directory);

        $files_formatted = [];

        foreach($files as $file) {
            $file_path_components = explode('/', $file);
            $file_name = end($file_path_components);

            $files_formatted[] = array(
                'name'  =>   $file_name,
                'src'   =>  '/storage/' . $file
            );
        }

        return $files_formatted;
    }

    public static function storeFiles($item_id, $name, $file) {
        $artwork_directory = StorageHelper::createItemDirectoryString($item_id);
        $file->storeAs('tasks/', '/' . $artwork_directory . '/' . str_replace(' ', '_', $name) . '.' . $file->extension());
    }
}
