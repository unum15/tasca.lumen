<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartialTextMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sort_order',
        'partial_text_message_type_id',
    ];

    public function partial_text_message_type()
    {
        return $this->belongsTo('App\PartialTextMessageType');
    }
}
