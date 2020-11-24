<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetFueling extends Model
{
    protected $fillable = [
        'asset_id',
        'asset_usage_type_id',
        'usage',
        'date',
        'gallons',
        'amount',
        'notes'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
