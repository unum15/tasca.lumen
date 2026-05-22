<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_service_id',
        'asset_usage_type_id',
        'usage',
        'date',
        'amount',
        'where',
        'notes'
    ];

    protected $casts = [
        'amount' => 'float',
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
