<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetUsageType extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
