<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLevel extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'notes',
        'sort_order',
        'default'
    ];
}
