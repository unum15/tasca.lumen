<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackflowValveParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_valve_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('backflow_type_valve_id');
            $table->string('name');
            $table->timestamps();
            
            $table->foreign('backflow_type_valve_id')
                ->references('id')
                ->on('backflow_type_valves')
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
        Schema::dropIfExists('backflow_valve_parts');
    }
}
