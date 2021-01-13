<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaborActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'sort_order',
        'parent_id'
    ];
    
    public function children(){
        return $this->hasMany(self::class, 'parent_id');
    }
    
    public function labor_assignments(){
        return $this->belongsToMany('App\LaborAssignment');
    }
}
