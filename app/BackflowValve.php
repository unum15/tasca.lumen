<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackflowValve extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];

    public function backflow_super_types()
    {
        return $this->belongsToMany('App\BackflowSuperType');
    }

    public function backflow_valve_parts()
    {
        return $this->belongsToMany('App\BackflowValvePart');
    }
}
