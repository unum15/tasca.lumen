<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAppointmentStatus extends Model
{
	protected $fillable = [
		'name',
		'notes',
		'sort_order'
	];
}
