<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDate extends Model
{
	protected $fillable = [
		'task_id',
		'date',
		'time',
        'day',
		'creator_id',
		'updater_id'
	];
	
	public function task(){
		return $this->belongsTo('App\Task');
	}
}
