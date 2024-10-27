<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartialTextMessageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
    ];
}
