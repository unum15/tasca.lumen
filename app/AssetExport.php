<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'exported_at'
    ];
}
