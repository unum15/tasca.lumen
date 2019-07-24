<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
    'contact_id',
    'email_type_id',
    'email',
    'creator_id',
    'updater_id'
    ];
    
    public function emailType()
    {
        return $this->belongsTo('App\EmailType');
    }
}
