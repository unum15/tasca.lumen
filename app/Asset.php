<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'asset_category_id',
        'asset_brand_id',
        'asset_type_id',
        'asset_group_id',
        'asset_sub_id',
        'item_number',
        'asset_usage_type_id',
        'year',
        'make',
        'model',
        'trim',
        'vin',
        'parent_asset_id',
        'notes',
        'asset_location_id',
        'manufacture',
        'number',
        'purchase_cost',
        'purchase_date'
    ];

    public function asset_category()
    {
        return $this->belongsTo('App\AssetCategory');
    }
    
    public function asset_brand()
    {
        return $this->belongsTo('App\AssetBrand');
    }
    
    public function asset_type()
    {
        return $this->belongsTo('App\AssetType');
    }
    
    public function asset_group()
    {
        return $this->belongsTo('App\AssetGroup');
    }
    
    public function asset_sub()
    {
        return $this->belongsTo('App\AssetSub');
    }

    public function asset_location()
    {
        return $this->belongsTo('App\AssetLocation');
    }

    public function asset_usage_type()
    {
        return $this->belongsTo('App\AssetUsageType');
    }
    
    public function parent_asset()
    {
        return $this->belongsTo('App\Asset','parent_asset_id');
    }
}
