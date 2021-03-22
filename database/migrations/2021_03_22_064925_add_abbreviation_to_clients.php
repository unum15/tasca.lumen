<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbbreviationToClients extends Migration
{

    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('abbreviation')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('abbreviation');
        });
    }
}
