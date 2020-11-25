<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetUnit extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
