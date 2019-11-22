<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowUse extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
