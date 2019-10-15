<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Helper\Storage as StorageHelper;

class ProjectArtwork extends Model
{
    protected $table = 'project_artwork';

    protected $fillable = [
        'project_id', 'artwork_type_id', 'creator_id', 'artwork_url', 'material', 'description', 'print_code', 'name', 'width', 'height', 'depth', 'what3words_code', 'internally_approved', 'internal_approver_id', 'internally_approved_at', 'client_approved', 'client_approver_id', 'client_approved_at', 'ready_to_print'
    ];

    protected $appends = array('src');

    public function artwork_type()
    {
        return $this->belongsTo('App\ProjectArtworkType','artwork_type_id', 'id');
    }

    public function amendRequests() {
        return $this->hasMany('App\ProjectArtworkAmendRequest','artwork_id', 'id');
    }

    public function amends() {
        return $this->hasMany('App\ProjectArtworkAmend','project_artwork_id', 'id');
    }

    public function internalAmendRequests() {
        return $this->amendRequests()->whereNotNull('internal_requester_id');
    }

    public function clientAmendRequests() {
        return $this->amendRequests()->whereNotNull('client_requester_id');
    }

    public function src() {
        $artwork_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-artwork/'.$artwork_directory);

        if(!empty($files)) {
            return '/storage/' . $files[0];
        }

        return false;
    }

    public function getSrcAttribute() {
        $artwork_directory = StorageHelper::getItemDirectory($this->id);

        $files = Storage::files('project-artwork/'.$artwork_directory);

        if(!empty($files)) {
            return '/storage/' . $files[0];
        }

        return false;
    }

    public static function storeArtwork($artwork_id, $name, $file) {
        $artwork_directory = StorageHelper::createItemDirectoryString($artwork_id);
        $file->storeAs('project-artwork/', '/' . $artwork_directory . '/' . str_replace(' ', '_', $name) . '.' . $file->extension());
    }
}
