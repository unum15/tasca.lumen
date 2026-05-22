<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'number',
        'name',
        'address',
        'city',
        'access_code',
        'notes',
        'backflow_water_system_id'
    ];
}
