<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'vehicle_type_id',
        'year',
        'make',
        'model',
        'trim',
        'vin',
        'notes'
    ];

    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType');
    }
}