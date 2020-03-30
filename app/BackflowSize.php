<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowSize extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order'
    ];
    
    public function backflow_models()
    {
        return $this->belongsToMany('App\BackflowModel');
    }
}
