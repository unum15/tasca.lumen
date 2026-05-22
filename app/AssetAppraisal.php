<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAppraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'date',
        'appraisal',
        'name',
    ];

    protected $casts = [
        'appraisal' => 'float',
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
