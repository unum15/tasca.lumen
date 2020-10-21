<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationController extends Model
{
    protected $fillable = [
        'irrigation_system_id',
        'name',
        'placement',
        'irrigation_controller_location_id',
        'model',
        'zones',
        'property_unit_id',
        'username',
        'accessible',
        'password',
        'notes'
    ];

    public function irrigation_system()
    {
        return $this->belongsTo('App\IrrigationSystem');
    }
}
