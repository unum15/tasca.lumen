<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_assembly_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('valve_1_psi_across');
            $table->integer('valve_1_check');
            $table->integer('valve_2_psi_across');
            $table->integer('valve_2_check');
            $table->integer('differential_pressure_relief_valve_opened_at');
            $table->integer('opened_under_1');
            $table->integer('pressure_vacuum_breaker_opened_at');
            $table->integer('opened_under_2');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backflow_assembly_tests');
    }
}
