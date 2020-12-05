<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTimeUnit extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
