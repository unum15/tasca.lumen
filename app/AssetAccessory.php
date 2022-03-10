<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAccessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'name',
        'notes',
        'value'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
