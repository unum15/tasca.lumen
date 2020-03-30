<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowManufacturer extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
