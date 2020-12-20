<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetLocation extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
