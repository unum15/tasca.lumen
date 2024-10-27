<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
        'asset_brand_id',
        'number',
    ];

    public function asset_brand()
    {
        return $this->belongsTo('App\AssetBrand');
    }
}
