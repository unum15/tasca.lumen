<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationController extends Model
{
    protected $fillable = [
        'irrigation_system_id',
        'name',
        'location',
        'model',
        'zones',
        'property_unit_id',
        'password'
    ];

    public function irrigation_system()
    {
        return $this->belongsTo('App\IrrigationSystem');
    }
}
