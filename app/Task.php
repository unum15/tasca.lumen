<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable =  [
      'order_id',
      'name',
      'description',
      'labor_type_id',
      'task_status_id',
      'task_action_id',
      'labor_assignment_id',
      'completion_date',
      'job_hours',
      'crew_hours',
      'task_hours',
      'crew_id',
      'notes',
      'group',
      'closed_date',
      'billed_date',
      'invoiced_date',
      'hold_date',
      'creator_id',
      'updater_id',
      'hide'
    ];
  
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
  
    public function task_action()
    {
        return $this->belongsTo('App\TaskAction');
    }
  
    public function labor_assignment()
    {
        return $this->belongsTo('App\LaborAssignment');
    }
    
    public function task_status()
    {
        return $this->belongsTo('App\TaskStatus');
    }
  
    public function labor_type()
    {
        return $this->belongsTo('App\LaborType');
    }
  
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
  
    public function crew()
    {
        return $this->belongsTo('App\Crew');
    }
  
}
