<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhreeBooksIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('phreebooks_id')->nullable();
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('phreebooks_id')->nullable();
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('phreebooks_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('phreebooks_id');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('phreebooks_id');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('phreebooks_id');
        });
    }
}
