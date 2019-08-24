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

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    public function service_type()
    {
        return $this->belongsTo('App\ServiceType');
    }

    public function usage_type()
    {
        return $this->belongsTo('App\UsageType');
    }
}
