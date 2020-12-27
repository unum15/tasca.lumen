<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetServiceType extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
