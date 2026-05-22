<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'number',
        'phone',
        'notes',
        'coordinates'
    ];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
