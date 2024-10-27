<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
    ];
}
