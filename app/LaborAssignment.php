<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaborAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
        'parent_id'
    ];
    
    public function children(){
        return $this->hasMany(self::class, 'parent_id')
        ->orderBy('sort_order')
        ->orderBy('name');
    }
    
    public function labor_activities()
    {
        return $this->belongsToMany('App\LaborActivity')
        ->orderBy('sort_order')
        ->orderBy('name');
    }
    
    public function labor_types()
    {
        return $this->belongsToMany('App\LaborType')
        ->withPivot('order_id');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
