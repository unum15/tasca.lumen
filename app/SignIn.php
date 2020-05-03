<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignIn extends Model
{
    protected $fillable = [
        'task_date_id',
        'clock_in_id',
        'overhead_assignment_id',
        'overhead_category_id',
        'sign_in',
        'sign_out',
        'notes',
        'creator_id',
        'updater_id'
    ];
    
    function taskDate()
    {
        return $this->belongsTo('App\TaskDate');
    }
    
    function clockIn()
    {
        return $this->belongsTo('App\ClockIn');
    }
    
    function overheadAssignment()
    {
        return $this->belongsTo('App\OverheadAssignment');
    }
    
    function overheadCategory()
    {
        return $this->belongsTo('App\OverheadCategory');
    }
}
