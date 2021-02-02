<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_group_id',
        'name',
        'number',
        'notes',
        'sort_order'
    ];

    public function asset_group()
    {
        return $this->belongsTo('App\AssetGroup');
    }
}
