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
            $table->increments('backflow_assembly_index');
            $table->integer('property_index');
            $table->integer('contact_index');
            $table->string('water_system',32)->nullable();
            $table->string('use',32)->nullable();
            $table->string('placement',1024)->nullable();
            $table->integer('backflow_style_index')->nullable();
            $table->string('manufacturer',64)->nullable();
            $table->string('size',32)->nullable();
            $table->string('model_number',32)->nullable();
            $table->string('serial_number',128)->nullable();
            $table->string('notes',1024)->nullable();            
            $table->timestamps();
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
