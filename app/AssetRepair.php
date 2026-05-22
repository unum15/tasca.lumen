<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetRepair extends Model
{
    use HasFactory;

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

    protected $casts = [
        'amount' => 'float',
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
