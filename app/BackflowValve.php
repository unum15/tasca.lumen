<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowValve extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
    
    public function backflow_types()
    {
        return $this->belongsToMany('App\BackflowType');
    }
    
    public function backflow_valve_parts()
    {
        return $this->belongsToMany('App\BackflowValvePart');
    }
}
