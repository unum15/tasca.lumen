<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsMessageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uses_date',
        'sort_order',
    ];
}
