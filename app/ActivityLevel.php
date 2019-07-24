<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLevel extends Model
{
    protected $fillable =[
    'name',
    'notes',
        'sort_order',
        'default'
    ];
}
