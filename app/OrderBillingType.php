<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderBillingType extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order'
	];
}
