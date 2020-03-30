<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowOldTest extends Model
{
    protected $fillable = [
        'backflow_old_id',
        'test_date',
        'check_1',
        'check_2',
        'rp_check_1',
        'rp_check_2',
        'rp',
        'ail',
        'ch_1'
    ];
}
