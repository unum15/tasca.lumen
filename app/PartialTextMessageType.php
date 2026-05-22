<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartialTextMessageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
        'creator_id',
        'updater_id',
    ];
}
