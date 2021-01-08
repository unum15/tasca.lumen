<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyAbbreviation extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('abbreviation')->nullable();
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('abbreviation');
        });
    }
}
