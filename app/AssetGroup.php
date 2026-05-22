<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_type_id',
        'name',
        'number',
        'notes',
        'sort_order',
        'creator_id',
        'updater_id',
    ];

    public function asset_type()
    {
        return $this->belongsTo('App\AssetType');
    }
}
