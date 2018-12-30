<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'allow_work_order',
        'allow_pending_work_order'
	];
	
	public function orderActions(){
        return $this->hasMany('App\OrderAction');
    }	
}
