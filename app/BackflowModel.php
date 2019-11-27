<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowModel extends Model
{
    protected $fillable = [
        'backflow_manufacturer_id',
        'backflow_type_id',
        'name',
        'notes',
        'sort_order'
    ];
}
