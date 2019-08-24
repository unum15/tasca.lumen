<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'service_id',
        'ending_reading',
        'date',
        'amount',
        'where',
        'notes'
    ];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
