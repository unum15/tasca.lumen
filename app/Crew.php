<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    protected $fillable = [
    'name',
    'notes',
    'sort_order',
        'default'
    ];
}
