<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable =  [
      'order_id',
      'name',
      'description',
      'task_type_id',
      'task_status_id',
      'task_action_id',
      'task_category_id',
      'task_appointment_status_id',
      'completion_date',
      'job_hours',
      'crew_hours',
      'crew_id',
      'notes',
      'group',
      'creator_id',
      'updater_id'
    ];
  
  public function order(){
    return $this->belongsTo('App\Order');
  }
  
  public function taskAction(){
    return $this->belongsTo('App\TaskAction');
  }
  
  public function taskCategory(){
    return $this->belongsTo('App\TaskCategory');
  }
  
  public function taskStatus(){
    return $this->belongsTo('App\TaskStatus');
  }
  
  public function taskAppointmentStatus(){
    return $this->belongsTo('App\TaskAppointmentStatus');
  }
  
  public function taskType(){
    return $this->belongsTo('App\TaskType');
  }
  
  public function dates(){
    return $this->hasMany('App\TaskDate');
  }
  
  public function crew(){
    return $this->belongsTo('App\Crew');
  }
  
}
