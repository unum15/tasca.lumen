<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order'
	];
}
