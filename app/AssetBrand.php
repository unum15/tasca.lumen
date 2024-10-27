<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_category_id',
        'name',
        'number',
        'notes',
        'sort_order',
    ];

    public function asset_category()
    {
        return $this->belongsTo('App\AssetCategory');
    }
}
