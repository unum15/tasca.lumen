<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGPSToUnits extends Migration
{

    public function up()
    {
        Schema::table('property_units', function (Blueprint $table) {
            $table->string('coordinates')->nullable();
        });
    }

    public function down()
    {
        Schema::table('property_units', function (Blueprint $table) {
            $table->dropColumn('coordinates');
        });
    }
}
