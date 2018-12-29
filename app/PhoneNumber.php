<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{    
	protected $fillable = [
		'contact_id',
		'phone_number_type_id',
		'phone_number',
		'creator_id',
		'updater_id'
	];
	
	public function phoneNumberType(){
        return $this->belongsTo('App\PhoneNumberType');
    }
}
