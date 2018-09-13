<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAction extends Model
{
	protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default',
		'task_status_id'
	];
	
	public function taskStatus(){
		return $this->belongsTo('App\Model\TaskStatus');
	}
}
