<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    protected $fillable = [
        'name',        
        'notes',
        'sort_order'
    ];
}
