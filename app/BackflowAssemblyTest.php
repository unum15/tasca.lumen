<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowAssemblyTest extends Model
{
    protected $fillable = [
        'visual_inspection_notes',
        'backflow_installation_status_id',
        'valve_1_psi_across',
        'valve_1_test_status_id',
        'valve_2_psi_across',
        'valve_2_test_status_id',
        'differential_pressure_relief_valve_opened_at',
        'opened_under_2_status_id',
        'pressure_vacuum_breaker_opened_at',
        'opened_under_1_status_id'
    ];
}
