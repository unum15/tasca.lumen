<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCrewLaborRateContact extends Migration
{

    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('crew_id')->nullable();
            $table->decimal('labor_rate')->nullable();
            $table->foreign('crew_id')
                ->references('id')
                ->on('crews')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('crew_id');
            $table->dropColumn('labor_rate');
        });
    }
}
