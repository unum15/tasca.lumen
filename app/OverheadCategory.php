<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverheadCategory extends Model
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
}
