<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowSize extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
