<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowStyle extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
