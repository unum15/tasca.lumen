<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowCleaning extends Model
{
    protected $fillable = [
        'backflow_test_report_id',
        'contact_id',
        'backflow_valve_id',
        'backflow_valve_part_id',
        'cleaned_on'
    ];

    public function backflow_test_report()
    {
        return $this->belongsTo('App\BackflowTestReport');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function backflow_valve()
    {
        return $this->belongsTo('App\BackflowValve');
    }

    public function backflow_valve_part()
    {
        return $this->belongsTo('App\BackflowValvePart');
    }
}
