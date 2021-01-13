<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'date',
        'time',
        'day',
        'notes',
        'hours',
        'sort_order',
        'appointment_status_id',
        'creator_id',
        'updater_id'
    ];
    
    public function task()
    {
        return $this->belongsTo('App\Task');
    }
    
    public function clockIns()
    {
        return $this->hasMany('App\ClockIn');
    }
    
    public function appointmentStatus()
    {
        return $this->belongsTo('App\AppointmentStatus');
    }
}
