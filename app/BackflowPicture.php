<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowPicture extends Model
{
    protected $fillable = [
        'backflow_assembly_id',
        'filename',
        'original_filename',
        'notes'
    ];

    public function backflow_assembly()
    {
        return $this->belongsTo('App\BackflowAssembly');
    }
}
