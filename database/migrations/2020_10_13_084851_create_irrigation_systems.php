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
            $table->integer('stops')->nullable();
            $table->integer('points_of_connection')->nullable();
            $table->integer('irrigation_water_type_id')->nullable();
            $table->integer('filters')->nullable();
            $table->timestamps();
            
            $table->foreign('irrigation_water_type_id')
                ->references('id')
                ->on('irrigation_water_types')
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
