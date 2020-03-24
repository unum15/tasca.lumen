<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    protected $fillable = [
        'name',
        'unit_number',
        'unit_phone',
        'unit_notes'
    ];
}
