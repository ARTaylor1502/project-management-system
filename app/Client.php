<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Image;

class Client extends Model
{
    protected $fillable = [
        'name', 'main_contact', 'landline_tele', 'mobile_number', 'company_colour', 'website', 'account_manager_id', 'client_type_id', 'private_notes'
    ];

    protected $appends = array('primary_address', 'aliases', 'primaryContact', 'activeProjects', 'completedProjects');

    public function logo() {
        return Image::findImage('storage/clients/'.$this->id.'/assets/logo/','logo', array('jpg', 'jpeg', 'png'));
    }

    public function events()
    {
        return $this->hasMany('App\Event', 'client_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany('App\ClientContact', 'client_id', 'id')->orderBy('first_name')->orderBy('last_name');
    }

    public function aliases()
    {
        return $this->hasMany('App\ClientAlias', 'client_id', 'id');
    }

    public function getAliasesAttribute() {
        return $this->aliases();
    }

    public function addresses()
    {
        return $this->hasMany('App\ClientAddress', 'client_id', 'id');
    }

    public function getAddressesAttribute() {
        return $this->addresses();
    }

    public function getPrimaryAddressAttribute() {
        if($address = $this->addresses()->where('is_primary_address', 1)->first()) {
            $address_components = array($address->address_first_line, $address->address_second_line, $address->address_town, $address->address_county);

            return implode(', ', array_filter($address_components)) . ' ' . $address->address_postcode;
        }

        return false;
    }

    public function getPrimaryContactAttribute() {
        return $this->contacts->where('is_primary_contact', 1)->first();
    }

    public function primaryContact() {
        return $this->contacts->where('is_primary_contact', 1)->first();
    }

    public function projects()
    {
        return $this->hasMany('App\Project', 'client_id', 'id');
    }

    public function getActiveProjectsAttribute() {
        return $this->projects->where('status_id', '<>' , 5);
    }

    public function activeProjects() {
        return $this->projects->where('status_id', '<>' , 5);
    }

    public function getCompletedProjectsAttribute() {
        return $this->projects->where('status_id', 5);
    }

    public function completedProjects() {
        return $this->projects->where('status_id', 5);
    }

    public function passwords() {
        return $this->hasMany('App\ClientPassword', 'client_id', 'id');
    }
}
