<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowTest extends Model
{
    protected $fillable = [
        'backflow_test_report_id',
        'contact_id',
        'reading_1',
        'reading_2',
        'tested_on'
    ];

    public function backflow_test_report()
    {
        return $this->belongsTo('App\BackflowTestReport');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
