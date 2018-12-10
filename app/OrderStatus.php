<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
	
	public function orderActions(){
        return $this->hasMany('App\OrderAction');
    }	
}
