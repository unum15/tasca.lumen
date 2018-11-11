<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'notes',
		'property_id',
		'contact_id',
        'open_date',
        'close_date', 
        'creator_id',
        'updater_id'
    ];
    
    public function property(){
        return $this->belongsTo('App\Property');
    }
    
    public function contact(){
        return $this->belongsTo('App\Contact');
    }
}
