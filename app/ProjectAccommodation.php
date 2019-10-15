<?php

namespace App;

use App\Helper\Storage as StorageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectAccommodation extends Model
{
    protected $table = 'project_accommodation';

    protected $fillable = [
        'project_id', 'venue_id', 'number_of_rooms', 'notes', 'check_in', 'check_out'
    ];

    protected $appends = array('attachments');

    public function venue()
    {
        return $this->belongsTo('App\Venue', 'venue_id', 'id');
    }

    public function getAttachmentsAttribute() {
        $project_accommodation_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-accommodation/'.$project_accommodation_directory);

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

    public static function storeAttachment($accommodation_id, $name, $file) {
        $accommodation_directory = StorageHelper::createItemDirectoryString($accommodation_id);
        $file->storeAs('project-accommodation/', '/' . $accommodation_directory . '/' . str_replace(' ', '_', explode('.',$name)[0]) . '.' . $file->extension());
    }
}
