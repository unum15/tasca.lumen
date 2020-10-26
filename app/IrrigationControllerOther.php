<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationControllerOther extends Model
{
    protected $fillable = [
        'irrigation_controller_id',
        'name',
        'value'
    ];

    public function irrigation_controller()
    {
        return $this->belongsTo('App\IrrigationController');
    }
}
