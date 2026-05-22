<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IrrigationSystemOther extends Model
{
    use HasFactory;

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
