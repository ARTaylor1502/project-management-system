<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helper\Image;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'department_id', 'role_id', 'title_id', 'landline_tele', 'mobile_tele', 'last_login',
    ];

    protected $appends = array('full_name', 'avatar', 'last_login_formatted', 'created_at_formatted', 'updated_at_formatted', 'primary_address');

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isStaff() {
        if($this->role()->first()->name == 'Staff') {
            return true;
        }

        return false;
    }

    public function isClient() {
        if($this->role()->first()->name == 'Client') {
            return true;
        }

        return false;
    }

    public function avatar() {
        return Image::findImage('storage/users/'.$this->id.'/assets/avatar/','avatar', array('jpg', 'jpeg', 'png'));
    }

    public function getAvatarAttribute() {
        return Image::findImage('storage/users/'.$this->id.'/assets/avatar/','avatar', array('jpg', 'jpeg', 'png'));
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function full_name() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getLastLoginFormattedAttribute() {
        if(!is_null($this->last_login)) {
            return date('d/m/Y H:i', strtotime($this->last_login));
        }

        return false;
    }

    public function getCreatedAtFormattedAttribute() {
        if(!is_null($this->created_at)) {
            return date('d/m/Y H:i', strtotime($this->created_at));
        }

        return false;
    }

    public function getUpdatedAtFormattedAttribute() {
        if(!is_null($this->updated_at)) {
            return date('d/m/Y H:i', strtotime($this->updated_at));
        }

        return false;
    }

    public function activeTasks() {
        if ($this->isStaff()) {
            return $this->tasks()->active();
        }

        return false;
    }

    public function completedTasks() {
        if($this->isStaff()) {
            return $this->tasks()->completed();
        }

        return false;
    }

    public function artworkApproved() {
        if($this->isStaff()) {
            return $this->artwork();
        }

        return false;
    }

    public function scopeStaff($query) {
        $query->where('role_id', 1);
    }

    public function artwork() {
        return $this->hasMany('App\ProjectArtwork', 'creator_id');
    }

    public function tasks() {
        return $this->hasMany('App\Task', 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne('App\UserRole', 'id', 'role_id');
    }

    public function title()
    {
        return $this->hasOne('App\UserTitle', 'id', 'title_id');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function projects() {
        return $this->belongsToMany('App\Project', 'project_users', 'user_id');
    }

    public function events() {
        $events = array();

        $projects = $this->projects()->with('event')->get();

        foreach($projects as $project) {
            $events[] = $project->event;
        }

        return $events;
    }

    public function addresses() {
        return $this->hasMany('App\UserAddress', 'user_id');
    }

    public function getPrimaryAddressAttribute() {
        if($address = $this->addresses()->where('is_primary_address', 1)->first()) {
            $address_components = array($address->address_first_line, $address->address_second_line, $address->address_town, $address->address_county);

            return implode(', ', array_filter($address_components)) . ' ' . $address->address_postcode;
        }

        return false;
    }
}
