<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAccount extends Model
{
    protected $fillable = [
        'property_id',
        'number',
        'name',
        'address',
        'city',
        'access_code',
        'notes'
    ];
}
