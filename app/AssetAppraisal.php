<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetAppraisal extends Model
{
    protected $fillable = [
        'asset_id',
        'date',
        'appraisal'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
