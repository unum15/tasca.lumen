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
}
