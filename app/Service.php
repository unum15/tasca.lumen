<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'vehicle_id',
        'service_type_id',
        'description',
        'quantity',
        'usage_type_id',
        'usage_interval',
        'part_number',
        'notes',
        'time_interval'
    ];
}
