<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetPicture extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'filename',
        'original_filename',
        'notes',
        'name',
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
