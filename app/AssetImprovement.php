<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetImprovement extends Model
{
    protected $fillable = [
        'asset_id',
        'description',
        'details',
        'date',
        'cost'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
