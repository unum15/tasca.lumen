<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $fillable = [
		'name',
		'notes',
		'sort_order',
        'default'
	];
}
