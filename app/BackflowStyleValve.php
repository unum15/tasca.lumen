<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowStyleValve extends Model
{
    protected $fillable = [
        'backflow_style_id',
        'name',
        'test_name',
        'success_label',
        'fail_label'
    ];

    public function backflow_style()
    {
        return $this->belongsTo('App\BackflowStyle');
    }
    
    public function backflow_valve_parts()
    {
        return $this->hasMany('App\BackflowValvePart');
    }
}
