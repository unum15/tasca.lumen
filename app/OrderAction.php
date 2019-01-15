<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    protected $fillable = [
		'order_status_id',
		'name',
		'notes',
		'sort_order'
	];
	
	public function orderStatuses(){
		return $this->belongsToMany('App\OrderStatus');
	}
    
}
