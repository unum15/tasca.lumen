<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationSystem extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'stops',
        'points_of_connection',
        'irrigation_water_type_id',
        'filters'
    ];
    
    public function irrigation_controllers()
    {
        return $this->hasMany('App\IrrigationController');
    }
}
