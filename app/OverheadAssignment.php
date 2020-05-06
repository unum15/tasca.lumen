<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverheadAssignment extends Model
{
    protected $fillable = [
        'name',
        'notes',
        'sort_order',
        'parent_id'
    ];
    
    public function children(){
        return $this->hasMany(self::class, 'parent_id');
    }
    
    public function overhead_categories(){
        return $this->belongsToMany('App\OverheadCategory');
    }
}
