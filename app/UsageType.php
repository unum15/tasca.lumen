<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsageType extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
