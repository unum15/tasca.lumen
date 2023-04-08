<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartialTextMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sort_order',
        'partial_text_message_type_id'
    ];

    public function partial_text_message_type()
    {
        return $this->belongsTo('App\PartialTextMessageType');
    }
}
