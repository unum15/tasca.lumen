<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'number',
        'phone',
        'notes'
    ];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
