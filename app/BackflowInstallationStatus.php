<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowInstallationStatus extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
}
