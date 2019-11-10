<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowCertification extends Model
{
    protected $fillable = [
        'backflow_assembly_id',
        'visual_inspection_notes',
        'backflow_installation_status_id'
    ];

    public function backflow_assembly()
    {
        return $this->belongsTo('App\BackflowAssembly');
    }
}
