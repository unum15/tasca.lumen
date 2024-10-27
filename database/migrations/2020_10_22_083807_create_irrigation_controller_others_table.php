<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrrigationControllerOthersTable extends Migration
{
    public function up()
    {
        Schema::create('irrigation_controller_others', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('irrigation_controller_id');
            $table->string('name');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('irrigation_controller_id')
                ->references('id')
                ->on('irrigation_controllers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('irrigation_controller_others');
    }
}
