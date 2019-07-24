<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAction extends Model
{
    protected $fillable = [
    'name',
    'notes',
    'sort_order'
    ];
    
    public function taskTypes()
    {
        return $this->belongsToMany('App\TaskType');
    }
}
