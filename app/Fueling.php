<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fueling extends Model
{
    protected $fillable = [
        'vehicle_id',
        'beginning_reading',
        'ending_reading',
        'date',
        'gallons',
        'amount',
        'notes'
    ];
}
