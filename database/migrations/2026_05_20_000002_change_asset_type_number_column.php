<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAssetTypeNumberColumn extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE asset_types ALTER COLUMN number TYPE VARCHAR(255)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE asset_types ALTER COLUMN number TYPE CHAR(1) USING TRIM(number)::CHAR(1)');
    }
}
