<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowTypeValvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_type_valves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('backflow_type_id');
            $table->string('name');
            $table->string('test_name');
            $table->string('success_label');
            $table->string('fail_label');
            $table->timestamps();
            
            $table->foreign('backflow_type_id')
                ->references('id')
                ->on('backflow_types')
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
        Schema::dropIfExists('backflow_type_valves');
    }
}
