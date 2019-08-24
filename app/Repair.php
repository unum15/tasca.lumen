<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'vehicle_id',
        'repair',
        'ending_reading',
        'date',
        'amount',
        'where',
        'notes'
    ];

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }
}
