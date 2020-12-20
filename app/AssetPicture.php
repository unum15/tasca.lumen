<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetPicture extends Model
{
    protected $fillable = [
        'asset_id',
        'filename',
        'original_filename',
        'notes'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
