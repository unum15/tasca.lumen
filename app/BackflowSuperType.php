<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowSuperType extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
    
    public function backflow_valves()
    {
        return $this->belongsToMany('App\BackflowValve');
    }
}
