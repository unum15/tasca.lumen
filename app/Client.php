<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
 	protected $fillable =[
		'name',
		'notes',
		'client_type_id',
		'activity_level_id',
		'billing_contact_id',		
		'main_mailing_property_id',		
		'contact_method_id',
//		'bill_to',
//		'attention_to',
		'referred_by',
		'creator_id',
		'updater_id',
        'phreebooks_id'
	];
	
	public function activityLevel(){
		return $this->belongsTo('App\ActivityLevel');
	}
	
	
	public function billingContact(){
		return $this->belongsTo('App\Contact');
	}
	
	public function mainMailingProperty(){
		return $this->belongsTo('App\Property');
	}
	
	public function clientType(){
		return $this->belongsTo('App\ClientType');
	}
	
	public function contactMethod(){
		return $this->belongsTo('App\ContactMethod');
	}	
	
	public function contacts(){
        return $this->belongsToMany('App\Contact')
			->withTimestamps()
            ->withPivot('contact_type_id')
			->orderBy('name')
			;
    }
	
	public function properties(){
        return $this->hasMany('App\Property')->orderBy('name');
    }	
	
}
