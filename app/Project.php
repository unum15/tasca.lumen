<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'notes',
        'contact_id',
        'open_date',
        'close_date', 
        'creator_id',
        'updater_id'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
