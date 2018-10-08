<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    protected $fillable = [
        'name',
        'phone',
        'address1',
        'address2',
        'city', 
        'state',
        'zip',
        'primary_contact_id',
        'work_property',
        'client_id',
        'address_type_id', 
        'activity_level_id',
		'property_type_id',
        'notes',
		'creator_id',
		'updater_id'
    ];
    
    public function client(){
        return $this->belongsTo('App\Client');
    }
    
    public function contact(){
        return $this->belongsTo('App\Contact');
    }
    
    public function propertyType(){
        return $this->belongsTo('App\PropertyType');
    }
    
    public function activeLevel(){
		return $this->belongsTo('App\ActiveLevel');
	}
    
    public function contacts(){
        return $this->belongsToMany('App\Contact');
    }
}
