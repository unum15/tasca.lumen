<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
     'name',
     'notes',
     'sort_order'
    ];
    
    public function orderActions()
    {
        return $this->hasMany('App\OrderAction');
    }    
}
