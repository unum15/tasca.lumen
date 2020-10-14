<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrrigationController extends Model
{
    protected $fillable = [
        'irrigation_system_id',
        'name',
        'model',
        'zones'
    ];
}
