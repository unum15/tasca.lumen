<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumberType extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
}
