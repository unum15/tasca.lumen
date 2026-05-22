<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackflowSize extends Model
{
    use HasFactory;

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
