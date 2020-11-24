<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetFueling extends Model
{
    protected $fillable = [
        'asset_id',
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
