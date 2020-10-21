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
            $table->string('placement')->nullable();
            $table->integer('irrigation_controller_location_id')->nullable();
            $table->string('model')->nullable();
            $table->integer('zones')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->integer('property_unit_id')->nullable();
            $table->boolean('accessible')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('irrigation_system_id')
                ->references('id')
                ->on('irrigation_systems')
                ->onDelete('cascade');

            $table->foreign('property_unit_id')
                ->references('id')
                ->on('property_units')
                ->onDelete('cascade');
                
            $table->foreign('irrigation_controller_location_id')
                ->references('id')
                ->on('irrigation_controller_locations')
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
