<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClockIn extends Model
{
    protected $fillable = [
        'task_date_id',
        'contact_id',
        'overhead_assignment_id',
        'overhead_category_id',
        'clock_in',
        'clock_out',
        'notes',
        'creator_id',
        'updater_id'
    ];
    
    function taskDate()
    {
        return $this->belongsTo('App\TaskDate');
    }
    
    function contact()
    {
        return $this->belongsTo('App\Contact');
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
