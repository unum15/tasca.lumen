<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationSystemOther extends Model
{
    protected $fillable = [
        'irrigation_system_id',
        'name',
        'value'
    ];

    public function irrigation_system()
    {
        return $this->belongsTo('App\IrrigationSystem');
    }
}
