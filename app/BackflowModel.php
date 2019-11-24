<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowModel extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
