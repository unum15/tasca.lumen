<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    protected $fillable = [
		'order_status_id',
		'name',
		'notes',
		'sort_order',
        'default'
	];
	
	public function orderStatus(){
		return $this->belongsTo('App\OrderStatus');
	}
    
}
