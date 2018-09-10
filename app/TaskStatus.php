<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
	protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
	
	public function taskActions(){
        return $this->hasMany('App\Model\TaskAction');
    }	
}
