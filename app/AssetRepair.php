<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetRepair extends Model
{
    protected $fillable = [
        'asset_id',
        'asset_usage_type_id',
        'usage',
        'repair',
        'date',
        'amount',
        'where',
        'notes'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function asset_usage_type()
    {
        return $this->belongsTo('App\AssetUsageType');
    }
}
