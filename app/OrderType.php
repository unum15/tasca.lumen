<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
