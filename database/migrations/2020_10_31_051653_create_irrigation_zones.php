<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrrigationZones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irrigation_zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('irrigation_controller_id');
            $table->integer('number');
            $table->string('name')->nullable();
            $table->string('plant_type')->nullable();
            $table->string('head_type')->nullable();
            $table->decimal('gallons_per_minute')->nullable();
            $table->decimal('application_rate')->nullable();
            $table->integer('heads')->nullable();
            $table->timestamps();
            
            $table->foreign('irrigation_controller_id')
                ->references('id')
                ->on('irrigation_controllers')
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
        Schema::dropIfExists('irrigation_zones');
    }
}
