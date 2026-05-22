<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'on_hand',
        'notes'
    ];
}
