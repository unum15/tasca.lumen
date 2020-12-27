<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model
{
    protected $fillable = [
        'asset_service_id',
        'asset_usage_type_id',
        'usage',
        'date',
        'amount',
        'where',
        'notes'
    ];

    public function asset_service()
    {
        return $this->belongsTo('App\AssetService');
    }

    public function asset_usage_type()
    {
        return $this->belongsTo('App\AssetUsageType');
    }
}
