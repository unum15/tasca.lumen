<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackflowTestReport extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat);
    }

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
        return $this->hasMany('App\BackflowTest')->orderBy('id');
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
