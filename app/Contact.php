<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'name',
		'notes',
		'activity_level_id',
		'contact_method_id',
        'login',
        'password',
        'google_calendar_token',
        'google_calendar_id',
		'creator_id',
		'updater_id'
    ];
    
	public function activeLevel(){
		return $this->belongsTo('App\Model\ActiveLevel');
	}
    
    public function clients(){
        return $this->belongsToMany('App\Model\Client');
    }
    
    public function contactMethod(){
		return $this->belongsTo('App\Model\ContactMethod');
	}
    
	public function emails(){
        return $this->hasMany('App\Model\Email');
    }
    
	public function phoneNumbers(){
        return $this->hasMany('App\Model\PhoneNumber');
    }
	
	public function properties(){
        return $this->belongsToMany('App\Model\Property');
    }
    
}
