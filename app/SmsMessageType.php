<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsMessageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uses_date',
        'sort_order',
        'creator_id',
        'updater_id',
    ];
}
