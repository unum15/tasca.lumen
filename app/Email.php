<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

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
