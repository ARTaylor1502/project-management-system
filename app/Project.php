<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'event_id', 'details', 'brief'
    ];

    protected $appends = array('last_updated_formatted');

    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Venue','venue_id','id');
    }

    public function client_contact()
    {
        return $this->belongsTo('App\ClientContact', 'client_contact_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\ProjectStatus', 'status_id', 'id');
    }

    public function project_owner()
    {
        return $this->belongsTo('App\User','project_owner_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','project_users');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task','project_id','id');
    }

    public function project_type()
    {
        return $this->belongsTo('App\ProjectType','project_type_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product','project_products')->withPivot('quantity');
    }

    public function accommodation()
    {
        return $this->hasMany('App\ProjectAccommodation','project_id', 'id');
    }

    public function getLastUpdatedFormattedAttribute() {
        return date('d/m/Y H:i', strtotime($this->updated_at));
    }

    public function lastUpdatedFormatted() {
        return date('d/m/Y H:i', strtotime($this->updated_at));
    }
}
