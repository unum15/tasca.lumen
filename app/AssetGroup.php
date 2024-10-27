<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_type_id',
        'name',
        'number',
        'notes',
        'sort_order',
    ];

    public function asset_type()
    {
        return $this->belongsTo('App\AssetType');
    }
}
