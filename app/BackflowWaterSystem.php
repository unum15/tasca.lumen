<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowWaterSystem extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'contact',
        'email',
        'notes',
        'sort_order',
        'abbreviation'
    ];
}
