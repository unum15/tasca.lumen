<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderStatus extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
	
	public function serviceOrderActions(){
        return $this->hasMany('App\Model\ServiceOrderAction');
    }	
}
