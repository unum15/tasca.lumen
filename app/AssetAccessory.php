<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAccessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'quantity',
        'name',
        'notes',
        'value',
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
