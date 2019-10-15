<?php

namespace App;

use App\Helper\Storage as StorageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectArtworkAmend extends Model
{
    protected $fillable = [
        'project_artwork_id', 'amend_request_id', 'creator_id', 'artwork_url', 'material', 'description', 'print_code', 'name', 'width', 'height', 'depth', 'what3words_code', 'internally_approved', 'internal_approver_id', 'internally_approved_at', 'client_approved', 'client_approver_id', 'client_approved_at', 'ready_to_print'
    ];

    protected $appends = array('src', 'createdAtDateFormatted', 'createdAtTimeFormatted');

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

    public static function storeArtworkAmendFile($amend_id, $name, $file) {
        $amend_directory = StorageHelper::createItemDirectoryString($amend_id);
        $file->storeAs('project-artwork-amends/', '/' . $amend_directory . '/' . str_replace(' ', '_', $name) . '.' . $file->extension());
    }

    public function src() {
        $artwork_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-artwork-amends/'.$artwork_directory);

        if(!empty($files)) {
            return '/storage/' . $files[0];
        }

        return false;
    }

    public function getSrcAttribute() {
        $artwork_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-artwork-amends/'.$artwork_directory);

        if(!empty($files)) {
            return '/storage/' . $files[0];
        }

        return false;
    }
}
