<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowModelNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('backflow_manufacturer_id');
            $table->integer('backflow_type_id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('backflow_type_id')
                ->references('id')
                ->on('backflow_types')
                ->onDelete('cascade');
                
            $table->foreign('backflow_manufacturer_id')
                ->references('id')
                ->on('backflow_manufacturers')
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
        Schema::dropIfExists('backflow_models');
    }
}
