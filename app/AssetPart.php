<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetPart extends Model
{
    protected $fillable = [
        'name',
        'on_hand',
        'notes'
    ];
}
