<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
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
