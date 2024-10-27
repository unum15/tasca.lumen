<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIrrigationSystemCosts extends Migration
{
    public function up()
    {
        Schema::table('irrigation_systems', function (Blueprint $table) {
            $table->decimal('start_up_cost')->nullable();
            $table->decimal('management_cost')->nullable();
            $table->decimal('winterizing_cost')->nullable();
            $table->integer('visits_count')->nullable();
        });
    }

    public function down()
    {
        Schema::table('irrigation_systems', function (Blueprint $table) {
            $table->dropColumn('start_up_cost')->nullable();
            $table->dropColumn('management_cost')->nullable();
            $table->dropColumn('winterizing_cost')->nullable();
            $table->dropColumn('visits_count')->nullable();
        });
    }
}
