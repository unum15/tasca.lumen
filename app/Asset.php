<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'asset_type_id',
        'asset_usage_type_id',
        'year',
        'make',
        'model',
        'trim',
        'vin',
        'parent_asset_id',
        'notes',
        'asset_location_id',
        'manufacture',
        'number',
        'purchase_cost',
        'purchase_date'
    ];

    public function asset_type()
    {
        return $this->belongsTo('App\AssetType');
    }

    public function asset_location()
    {
        return $this->belongsTo('App\AssetLocation');
    }

    public function asset_usage_type()
    {
        return $this->belongsTo('App\AssetUsageType');
    }
    
    public function parent_asset()
    {
        return $this->belongsTo('App\Asset','parent_asset_id');
    }
}
