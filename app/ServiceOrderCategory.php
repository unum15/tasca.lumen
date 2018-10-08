<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderCategory extends Model
{
    protected $fillable = [
		'service_order_status_id',
		'name',
		'notes',
		'sort_order'
	];

}
