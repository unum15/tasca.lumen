<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'contact_id',
        'labor_activity_id',
        'clock_in',
        'clock_out',
        'notes',
        'creator_id',
        'updater_id',
    ];

    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function labor_activity()
    {
        return $this->belongsTo('App\LaborActivity');
    }
}
