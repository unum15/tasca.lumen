<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IrrigationControllerOther extends Model
{
    use HasFactory;

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
