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
        Schema::create('backflows.backflow_assembly_tests', function (Blueprint $table) {
            $table->increments('backflow_assembly_test_index');
            $table->string('visual_inspection_notes');
            $table->integer('installation_status_index');
            $table->integer('valve_1_psi_across');
            $table->integer('valve_1_test_status_index');
            $table->integer('valve_2_psi_across');
            $table->integer('valve_2_test_status_index');
            $table->integer('differential_pressure_relief_valve_opened_at');
            $table->integer('opened_under_2_status_index');
            $table->integer('pressure_vacuum_breaker_opened_at');
            $table->integer('opened_under_1_status_index');
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
        Schema::dropIfExists('backflows.backflow_assembly_tests');
    }
}
