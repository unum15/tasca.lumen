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
        'api_token',
        'show_help',
        'show_maximium_activity_level_id',
        'default_service_window',
		'creator_id',
		'updater_id',
        'google_calendar_token',
        'google_calendar_id'
    ];
    
     protected $hidden = [
        'password','google_calendar_token','google_calendar_id','remember_token','api_token'
    ];
    
	public function activityLevel(){
		return $this->belongsTo('App\ActivityLevel');
	}
    
    public function clients(){
        return $this->belongsToMany('App\Client')
            ->withTimestamps()
            ->withPivot('contact_type_id');
    }
    
    public function contactMethod(){
		return $this->belongsTo('App\ContactMethod');
	}
    
	public function emails(){
        return $this->hasMany('App\Email');
    }
    
	public function phoneNumbers(){
        return $this->hasMany('App\PhoneNumber');
    }
	
	public function properties(){
        return $this->belongsToMany('App\Property')
            ->withTimestamps();
    }
    
    public function logIns(){
        return $this->hasMany('App\LogIn');
    }
    
}
