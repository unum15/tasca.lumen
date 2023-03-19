<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTextMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message'
    ];
}
