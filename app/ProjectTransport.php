<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTransport extends Model
{
    protected $table = 'project_transport';

    protected $fillable = [
        'project_id', 'vehicle_type_id', 'name', 'notes', 'start_date', 'end_date', 'rental_company', 'license_plate', 'colour'
    ];

    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType', 'vehicle_type_id', 'id');
    }
}
