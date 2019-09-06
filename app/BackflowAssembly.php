<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowAssembly extends Model
{
    protected $fillable = [
        'property_id',
        'contact_id',
        'water_system',
        'use',
        'placement',
        'backflow_style_id',
        'manufacturer',
        'size',
        'model_number',
        'serial_number',
        'notes'
    ];
}
