<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowTestReport extends Model
{
    protected $fillable = [
        'backflow_assembly_id',
        'visual_inspection_notes',
        'backflow_installed_to_code',
        'report_date',
        'submitted_date',
        'tag_year',
        'notes'
    ];

    public function backflow_assembly()
    {
        return $this->belongsTo('App\BackflowAssembly');
    }
    
    public function backflow_tests()
    {
        return $this->hasMany('App\BackflowTest')->orderBy('backflow_test_report_id');
    }
    
    public function backflow_repairs()
    {
        return $this->hasMany('App\BackflowRepair');
    }
    
    public function backflow_cleanings()
    {
        return $this->hasMany('App\BackflowCleaning');
    }
}
