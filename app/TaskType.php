<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
	protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
}
