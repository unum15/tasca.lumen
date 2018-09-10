<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contact extends Authenticatable
{
    use Notifiable;

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
