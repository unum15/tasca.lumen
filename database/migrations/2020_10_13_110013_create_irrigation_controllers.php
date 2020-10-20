<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrrigationControllers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irrigation_controllers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('irrigation_system_id');
            $table->string('name');
            $table->string('model')->nullable();
            $table->integer('zones')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
            
            $table->foreign('irrigation_system_id')
                ->references('id')
                ->on('irrigation_systems')
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
        Schema::dropIfExists('irrigation_controllers');
    }
}
