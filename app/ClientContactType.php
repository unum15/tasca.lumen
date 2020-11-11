<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientContactType extends Model
{

    protected $table = 'client_contact';
    protected $fillable = [
        'client_id',
        'contact_id',
        'contact_type_id',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function contact_type()
    {
        return $this->belongsTo('App\ContactType');
    }


}
