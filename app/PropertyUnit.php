<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'unit_number',
        'unit_phone',
        'unit_notes'
    ];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
