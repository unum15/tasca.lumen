<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_assemblies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('contact_id');
            $table->integer('backflow_type_id')->nullable();            
            $table->integer('backflow_water_system_id')->nullable();
            $table->integer('backflow_use_id')->nullable();
            $table->integer('backflow_manufacturer_id')->nullable();
            $table->integer('backflow_model_id')->nullable();
            $table->string('placement',1024)->nullable();
            $table->string('size',32)->nullable();            
            $table->string('serial_number',128)->nullable();
            $table->string('notes',1024)->nullable();            
            $table->timestamps();
            
            $table->foreign('property_id')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade');
                
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');
                
            $table->foreign('backflow_type_id')
                ->references('id')
                ->on('backflow_types')
                ->onDelete('cascade');
                
            $table->foreign('backflow_water_system_id')
                ->references('id')
                ->on('backflow_water_systems')
                ->onDelete('cascade');
                
            $table->foreign('backflow_use_id')
                ->references('id')
                ->on('backflow_uses')
                ->onDelete('cascade');
                
            $table->foreign('backflow_manufacturer_id')
                ->references('id')
                ->on('backflow_manufacturers')
                ->onDelete('cascade');
                
            $table->foreign('backflow_model_id')
                ->references('id')
                ->on('backflow_models')
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
        Schema::dropIfExists('backflow_assemblies');
    }
}
