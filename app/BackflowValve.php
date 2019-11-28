<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowValve extends Model
{
    protected $fillable = [
        'name',
        'test_label',
        'test_value',
        'success_label',
        'fail_label',
        'store_value'
    ];
    
    public function backflow_types()
    {
        return $this->belongsToMany('App\BackflowType');
    }
    
    public function backflow_valve_parts()
    {
        return $this->hasMany('App\BackflowValvePart');
    }
}
