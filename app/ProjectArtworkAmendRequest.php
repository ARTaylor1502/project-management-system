<?php

namespace App;

use App\Helper\Storage as StorageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectArtworkAmendRequest extends Model
{
    protected $appends = array('file', 'createdAtDateFormatted', 'createdAtTimeFormatted');

    public function internal_requester() {
        return $this->belongsTo('App\User','internal_requester_id');
    }

    public function getCreatedAtTimeFormattedAttribute() {
        if(!is_null($this->created_at)) {
            return date('H:i', strtotime($this->created_at));
        }

        return false;
    }

    public function getCreatedAtDateFormattedAttribute() {
        if(!is_null($this->created_at)) {
            return date('d/m/Y', strtotime($this->created_at));
        }

        return false;
    }

    public function client_requester() {
        return $this->belongsTo('App\ClientUser','client_requester_id');
    }

    public static function storeAmendRequestFile($amend_id, $file) {
        $amend_directory = StorageHelper::createItemDirectoryString($amend_id);
        $file->storeAs('project-artwork-amend-requests' . '/' . $amend_directory . '/', $file->getClientOriginalName());
    }

    public function getFileAttribute() {
        $file = [];

        $amend_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-artwork-amend-requests/'.$amend_directory);

        if(!empty($files)) {
            $file_path = $files[0];
            $file_array = explode('/', $file_path);
            $file['name'] = end($file_array);
            $file['src'] = '/storage/' . $file_path;

            return $file;
        }

        return false;
    }

    public function file() {
        $file = [];

        $amend_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-artwork-amend-requests/'.$amend_directory);

        if(!empty($files)) {
            return $file['name'] = '/storage/' . $files[0];
        }

        return false;
    }
}
