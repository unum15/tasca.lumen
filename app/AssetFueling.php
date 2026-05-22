<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetFueling extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'asset_usage_type_id',
        'usage',
        'date',
        'gallons',
        'amount',
        'notes'
    ];

    protected $casts = [
        'amount' => 'float',
        'gallons' => 'float',
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
