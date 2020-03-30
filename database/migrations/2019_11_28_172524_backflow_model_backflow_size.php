<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackflowModelBackflowSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_model_backflow_size', function (Blueprint $table) {
            $table->integer('backflow_model_id');
            $table->integer('backflow_size_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['backflow_model_id', 'backflow_size_id']);
            $table->foreign('backflow_model_id')
                ->references('id')->on('backflow_models')
                ->onDelete('cascade');
            $table->foreign('backflow_size_id')
                ->references('id')->on('backflow_sizes')
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
        Schema::dropIfExists('backflow_model_backflow_size');
    }
}
