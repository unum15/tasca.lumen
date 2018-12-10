<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCategory extends Model
{
    protected $fillable = [
		'order_status_id',
		'name',
		'notes',
		'sort_order'
	];

}
