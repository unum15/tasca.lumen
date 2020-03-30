<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowSuperTypeBackflowValve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_super_type_backflow_valve', function (Blueprint $table) {
            $table->integer('backflow_super_type_id');
            $table->integer('backflow_valve_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['backflow_super_type_id', 'backflow_valve_id']);
            $table->foreign('backflow_super_type_id')
                ->references('id')->on('backflow_super_types')
                ->onDelete('cascade');
            $table->foreign('backflow_valve_id')
                ->references('id')->on('backflow_valves')
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
        Schema::dropIfExists('backflow_super_type_backflow_valve');
    }
}
