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
        'phone_number',
        'work_property',
        'billing_property',
        'client_id',
        'address_type_id', 
        'activity_level_id',
        'property_type_id',
        'notes',
        'creator_id',
        'updater_id',
        'phreebooks_id'
    ];
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    public function propertyType()
    {
        return $this->belongsTo('App\PropertyType');
    }
    
    public function activityLevel()
    {
        return $this->belongsTo('App\ActivityLevel');
    }
    
    public function contacts()
    {
        return $this->belongsToMany('App\Contact')
            ->withTimestamps();
    }
    
    public function linkedClients()
    {
        return $this->belongsToMany('App\Client');
    }
}
