<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetHome extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order',
    ];
}
