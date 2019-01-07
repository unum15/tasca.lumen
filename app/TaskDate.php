<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDate extends Model
{
	protected $fillable = [
		'task_id',
		'date',
		'time',
        'hours',
		'creator_id',
		'updater_id'
	];
}
