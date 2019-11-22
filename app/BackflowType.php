<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowType extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
