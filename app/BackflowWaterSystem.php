<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowWaterSystem extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
