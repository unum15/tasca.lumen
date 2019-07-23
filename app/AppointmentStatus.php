<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    protected $fillable = [
    'name',
    'notes',
    'sort_order'
    ];
}
