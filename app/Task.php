<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable =  [
      'service_order_id',
      'work_order_id',
      'description',
      'billable',
      'task_type_id',
      'task_status_id',
      'task_action_id',
      'task_category_id',
      'day',
      'date',
      'time',
      'job_hours',
      'crew_hours',
      'notes',
      'sort_order'
    ];
  
  public function service_order(){
    return $this->belongsTo('App\ServiceOrder');
  }
}
