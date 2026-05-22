<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetImprovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'description',
        'details',
        'date',
        'cost',
        'name',
    ];

    protected $casts = [
        'cost' => 'float',
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
