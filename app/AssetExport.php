<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'exported_at',
    ];
}
