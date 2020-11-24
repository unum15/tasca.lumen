<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NoDefaultForContactType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_types', function (Blueprint $table) {
            $table->dropColumn('default');
        });
        Schema::table('client_types', function (Blueprint $table) {
            $table->dropColumn('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_types', function (Blueprint $table) {
            $table->boolean('default')->default('false');
        });
        Schema::table('client_types', function (Blueprint $table) {
            $table->boolean('default')->default('false');
        });
    }
}
