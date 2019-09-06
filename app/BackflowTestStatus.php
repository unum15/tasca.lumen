<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowTestStatus extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
