<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowValvePart extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];

    public function backflow_valve()
    {
        return $this->belongsToMany('App\BackflowValve');
    }
}
