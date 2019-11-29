<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowTestReport extends Model
{
    protected $fillable = [
        'backflow_assembly_id',
        'visual_inspection_notes',
        'backflow_installed_to_code'
    ];

    public function backflow_assembly()
    {
        return $this->belongsTo('App\BackflowAssembly');
    }
    
    public function backflow_tests()
    {
        return $this->hasMany('App\BackflowTest');
    }
}
