<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignIn extends Model
{
    protected $fillable = [
        'contact_id',
		'order_id',
        'sign_in',
		'sign_out',
        'notes',
        'creator_id',
        'updater_id'
	];
    
    function contact(){
       return $this->belongsTo('App\Contact');
    }
    
    function order(){
       return $this->belongsTo('App\Order');
    }
    
    
}
