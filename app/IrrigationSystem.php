<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationSystem extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'point_of_connection_location',
        'irrigation_water_type_id',
        'backflow_assembly_id',
        'filter_model',
        'filter_location',
        'property_unit_id',
        'notes'
    ];

    public function irrigation_water_type()
    {
        return $this->belongsTo('App\IrrigationWaterType');
    }

    public function backflow_assembly()
    {
        return $this->belongsTo('App\BackflowAssembly');
    }

    public function property_unit()
    {
        return $this->belongsTo('App\PropertyUnit');
    }

    public function irrigation_controllers()
    {
        return $this->hasMany('App\IrrigationController');
    }

    public function irrigation_system_others()
    {
        return $this->hasMany('App\IrrigationSystemOther');
    }
}
