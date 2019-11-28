<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowTypeValve extends Model
{
    protected $fillable = [
        'backflow_type_id',
        'name',
        'test_name',
        'success_label',
        'fail_label'
    ];

    public function backflow_type()
    {
        return $this->belongsTo('App\BackflowType');
    }
    
    public function backflow_valve_parts()
    {
        return $this->hasMany('App\BackflowValvePart');
    }
}
