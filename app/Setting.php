<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	public $fillable = [
		'name',
		'value'
	];
}
