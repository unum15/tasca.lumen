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
            $table->string('water_system',32)->nullable();
            $table->string('use',32)->nullable();
            $table->string('placement',1024)->nullable();
            $table->integer('backflow_style_id')->nullable();
            $table->string('manufacturer',64)->nullable();
            $table->string('size',32)->nullable();
            $table->string('model_number',32)->nullable();
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
                
            $table->foreign('backflow_style_id')
                ->references('id')
                ->on('backflow_styles')
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
