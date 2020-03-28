<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowOld extends Model
{
    protected $table = "backflow_old";
    public $timestamps = false;
    protected $fillable = [
        'active',
        'prt',
        'month',
        'reference',
        'water_system',
        'account',
        'owner',
        'contact',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'location',
        'laddress',
        'lcity',
        'lstate',
        'lzip',
        'gps',
        'use',
        'placement',
        'style',
        'manufacturer',
        'size',
        'model',
        'serial',
        'notes,',
        'backflow_assembly_id'
    ];
    
    public function backflow_old_tests()
    {
        return $this->hasMany('App\BackflowOldTest')->orderBy('test_date');
    }
}
