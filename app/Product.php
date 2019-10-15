<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'quantity_total', 'quantity_available', 'cost', 'cost_type_id'
    ];

    protected $appends = array('quantity');

    public function projects()
    {
        return $this->belongsToMany('App\Project','project_products');
    }

    public function getQuantityAttribute() {
        return $this->pivot->quantity;
    }
}
