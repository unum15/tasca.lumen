<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaterSystemToAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_accounts', function (Blueprint $table) {
            $table->integer('backflow_water_system_id')->nullable();
            $table->foreign('backflow_water_system_id')
                ->references('id')
                ->on('backflow_water_systems')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_accounts', function (Blueprint $table) {
            $table->dropColumn('backflow_water_system_id');
        });
    }
}
