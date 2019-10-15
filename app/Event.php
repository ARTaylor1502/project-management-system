<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Date as DateHelper;
use Illuminate\Support\Collection;

class Event extends Model
{
    protected $fillable = [
        'name', 'start_date', 'end_date'
    ];

    protected $appends = array('start_date_formatted', 'start_time_formatted', 'end_date_formatted', 'time_until_event', 'venue_address', 'clients');

    public function projects() {
        return $this->hasMany('App\Project');
    }

    public function venue() {
        return $this->belongsTo('App\Venue', 'primary_venue_id', 'id');
    }

    public function getClientsAttribute() {
        $projects = $this->projects()->get();

        $clients = new Collection();

        foreach($projects as $project) {
            $clients->push($project->client()->first());
        }

        return $clients->unique();
    }

    public function getVenueAddressAttribute() {
        $venue = $this->venue()->first();

        $address_components = array($venue->address_first_line, $venue->address_second_line, $venue->address_town, $venue->address_county);

        return implode(', ', array_filter($address_components)) . ' ' . $venue->address_postcode;
    }

    public function getStartDateFormattedAttribute() {
        return date('d/m/Y', strtotime($this->start_date));
    }

    public function getStartTimeFormattedAttribute() {
        return date('g:i a', strtotime($this->start_date));
    }

    public function getEndDateFormattedAttribute() {
        return date('d/m/Y', strtotime($this->end_date));
    }

    public function eventStartDateFormatted($format) {
        return date($format, strtotime($this->start_date));
    }

    public function eventEndDateFormatted($format) {
        return date($format, strtotime($this->end_date));
    }

    public function getTimeUntilEventAttribute() {
        $helper = new DateHelper();

        return $helper->getTimeUntilDate($this->start_date);
    }
}
