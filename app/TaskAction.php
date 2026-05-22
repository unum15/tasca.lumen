<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
    ];
    
    public function labor_types()
    {
        return $this->belongsToMany('App\LaborType')
        ->withPivot('sort_order')
        ->orderByPivot('sort_order');

    }
}
