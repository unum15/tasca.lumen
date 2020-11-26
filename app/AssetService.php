<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetService extends Model
{
    protected $fillable = [
        'asset_id',
        'asset_service_type_id',
        'description',
        'quantity',
        'asset_usage_type_id',
        'asset_unit_id',
        'usage_interval',
        'part_number',
        'notes',
        'time_interval'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function asset_service_type()
    {
        return $this->belongsTo('App\AssetServiceType');
    }

    public function asset_usage_type()
    {
        return $this->belongsTo('App\AssetUsageType');
    }
    
    public function asset_unit()
    {
        return $this->belongsTo('App\AssetUnit');
    }
}
