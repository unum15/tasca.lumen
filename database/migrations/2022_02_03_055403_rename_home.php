<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameHome extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->renameColumn('home', 'location');
            $table->renameColumn('asset_location_id', 'asset_home_id');
        });
        Schema::rename('asset_locations', 'asset_homes');

    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->renameColumn('location', 'home');
            $table->renameColumn('asset_home_id', 'asset_location_id');
        });
        Schema::rename('asset_homes', 'asset_locations');
    }
}
