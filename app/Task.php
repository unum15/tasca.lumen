<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable =  [
      'order_id',
      'name',
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
      'sort_order',
      'group'
    ];
  
  public function order(){
    return $this->belongsTo('App\Order');
  }
}
