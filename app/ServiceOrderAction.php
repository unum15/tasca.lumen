<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderAction extends Model
{
    protected $fillable = [
		'service_order_status_id',
		'name',
		'notes',
		'sort_order',
        'default'
	];
	
	public function serviceOrderStatus(){
		return $this->belongsTo('App\Model\ServiceOrderStatus');
	}
    
}
