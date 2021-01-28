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
        'parent_id',
        'order_id',
        'labor_type_id'
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
    
    public function labor_type()
    {
        return $this->belongsTo('App\LaborType');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
