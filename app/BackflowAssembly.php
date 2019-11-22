<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowAssembly extends Model
{
    protected $fillable = [
        'property_id',
        'contact_id',
        'backflow_type_id',
        'backflow_water_system_id',
        'backflow_use_id',
        'backflow_manufacturer_id',
        'backflow_model_id',
        'placement',
        'size',
        'serial_number',
        'notes'
    ];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function backflow_type()
    {
        return $this->belongsTo('App\BackflowType');
    }

    public function backflow_water_system()
    {
        return $this->belongsTo('App\BackflowWaterSystem');
    }

    public function backflow_us()
    {
        return $this->belongsTo('App\BackflowUs');
    }

    public function backflow_manufacturer()
    {
        return $this->belongsTo('App\BackflowManufacturer');
    }

    public function backflow_model()
    {
        return $this->belongsTo('App\BackflowModel');
    }
}
