<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCategory extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order'
	];

}
