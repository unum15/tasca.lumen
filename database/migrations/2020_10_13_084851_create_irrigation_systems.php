<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrrigationSystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irrigation_systems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('property_id');
            $table->string('name');
            $table->string('point_of_connection_location')->nullable();
            $table->integer('irrigation_water_type_id')->nullable();
            $table->integer('backflow_assembly_id')->nullable();
            $table->string('filter_model')->nullable();
            $table->string('filter_location')->nullable();
            $table->integer('property_unit_id')->nullable();
            $table->timestamps();

            $table->foreign('irrigation_water_type_id')
                ->references('id')
                ->on('irrigation_water_types')
                ->onDelete('cascade');

            $table->foreign('backflow_assembly_id')
                ->references('id')
                ->on('backflow_assemblies')
                ->onDelete('cascade');

            $table->foreign('property_unit_id')
                ->references('id')
                ->on('property_units')
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
        Schema::dropIfExists('irrigation_systems');
    }
}
