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
        'notes'
    ];

    public function asset_type()
    {
        return $this->belongsTo('App\AssetType');
    }

    public function asset_usage_type()
    {
        return $this->belongsTo('App\AssetUsageType');
    }
}
