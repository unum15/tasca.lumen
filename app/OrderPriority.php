<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPriority extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
}
