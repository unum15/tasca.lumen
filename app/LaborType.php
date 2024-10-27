<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
    ];

    public function labor_assignments()
    {
        return $this->hasMany('App\LaborAssignment');
    }

    public function task_actions()
    {
        return $this->belongsToMany('App\TaskAction');
    }

    public function task_statuses()
    {
        return $this->belongsToMany('App\TaskStatus');
    }
}
