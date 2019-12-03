<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowValveBackflowValvePart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_valve_backflow_valve_part', function (Blueprint $table) {
            $table->integer('backflow_valve_id');
            $table->integer('backflow_valve_part_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['backflow_valve_id', 'backflow_valve_part_id']);
            $table->foreign('backflow_valve_id')
                ->references('id')->on('backflow_valves')
                ->onDelete('cascade');
            $table->foreign('backflow_valve_part_id')
                ->references('id')->on('backflow_valve_parts')
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
        Schema::dropIfExists('backflow_valve_backflow_valve_part');
    }
}
