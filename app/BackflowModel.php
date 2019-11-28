<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackflowModel extends Model
{
    protected $fillable = [
        'backflow_manufacturer_id',
        'backflow_type_id',
        'name',
        'notes',
        'sort_order'
    ];

    public function backflow_type()
    {
        return $this->belongsTo('App\BackflowType');
    }

    public function backflow_manufacturer()
    {
        return $this->belongsTo('App\BackflowManufacturer');
    }

    public function backflow_sizes()
    {
        return $this->belongsToMany('App\BackflowSize');
    }
}
