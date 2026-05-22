<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackflowType extends Model
{
    use HasFactory;

    protected $fillable = [
        'backflow_super_type_id',
        'name',
        'notes',
        'sort_order'
    ];
    
    public function backflow_super_type()
    {
        return $this->belongsTo('App\BackflowSuperType');
    }
}
