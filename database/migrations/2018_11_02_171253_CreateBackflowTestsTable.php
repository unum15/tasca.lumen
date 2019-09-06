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
            $table->string('visual_inspection_notes');
            $table->integer('backflow_installation_status_id');
            $table->integer('valve_1_psi_across');
            $table->integer('valve_1_test_status_id');
            $table->integer('valve_2_psi_across');
            $table->integer('valve_2_test_status_id');
            $table->integer('differential_pressure_relief_valve_opened_at');
            $table->integer('opened_under_2_status_id');
            $table->integer('pressure_vacuum_breaker_opened_at');
            $table->integer('opened_under_1_status_id');
            $table->timestamps();
            
            $table->foreign('backflow_installation_status_id')
                ->references('id')
                ->on('backflow_installation_statuses')
                ->onDelete('cascade');
                
            $table->foreign('valve_1_test_status_id')
                ->references('id')
                ->on('backflow_test_statuses')
                ->onDelete('cascade');

            $table->foreign('opened_under_1_status_id')
                ->references('id')
                ->on('backflow_test_statuses')
                ->onDelete('cascade');
                
            $table->foreign('opened_under_2_status_id')
                ->references('id')
                ->on('backflow_test_statuses')
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
        Schema::dropIfExists('backflow_assembly_tests');
    }
}
