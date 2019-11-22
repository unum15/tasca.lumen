<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowValvePart extends Model
{
    protected $fillable = [
        'backflow_type_valve_id',
        'name'
    ];

    public function backflow_type_valf()
    {
        return $this->belongsTo('App\BackflowTypeValf');
    }
}
