<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClockIn extends Model
{
    protected $fillable = [
        'contact_id',
        'clock_in',
        'clock_out',
        'notes',
        'creator_id',
        'updater_id'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
