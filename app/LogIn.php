<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogIn extends Model
{
	protected $fillable = [
		'contact_id',
		'bearer_token',
        'user_agent',
        'host'
	];
}
