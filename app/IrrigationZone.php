<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationZone extends Model
{
    protected $fillable = [
        'irrigation_controller_id',
        'number',
        'name',
        'plant_type',
        'head_type',
        'gallons_per_minute',
        'application_rate',
        'heads'
    ];

    public function irrigation_controller()
    {
        return $this->belongsTo('App\IrrigationController');
    }
}
