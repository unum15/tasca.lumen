<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
    ];
}
