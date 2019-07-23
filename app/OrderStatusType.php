<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusType extends Model
{
    protected $fillable = [
    'name',
    'notes',
    'sort_order'
    ];
}
