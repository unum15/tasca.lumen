<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBackflowWaterSystemsAbbreviation extends Migration
{
    public function up()
    {
        Schema::table('backflow_water_systems', function (Blueprint $table) {
            $table->string('abbreviation')->nullable();
        });
    }

    public function down()
    {
        Schema::table('backflow_water_systems', function (Blueprint $table) {
            $table->dropColumn('abbreviation');
        });
    }
}
