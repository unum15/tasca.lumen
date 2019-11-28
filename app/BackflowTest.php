<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowTest extends Model
{
    protected $fillable = [
        'backflow_test_report_id',
        'backflow_valve_id',
        'passed',
        'pressure'
    ];
}
