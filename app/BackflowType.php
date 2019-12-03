<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowType extends Model
{
    protected $fillable = [
        'backflow_super_type_id',
        'name',
        'notes',
        'sort_order'
    ];
    
    public function backflow_valves()
    {
        return $this->belongsToMany('App\BackflowValve');
    }
}
