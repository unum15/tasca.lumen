<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderType extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order'
	];
}
