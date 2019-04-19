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
		'notes',
		'sort_order',
		'creator_id',
		'updater_id'
	];
	
	public function task(){
		return $this->belongsTo('App\Task');
	}
	
	public function signIns(){
		return $this->hasMany('App\SignIn');
	}
}
