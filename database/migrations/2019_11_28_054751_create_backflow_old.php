<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowOld extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_old', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('active');
            $table->string('prt');
            $table->string('month');
            $table->string('reference');
            $table->string('water_system');
            $table->string('account');
            $table->string('owner');
            $table->string('contact');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('location');
            $table->string('laddress');
            $table->string('lcity');
            $table->string('lstate');
            $table->string('lzip');
            $table->string('gps');
            $table->string('use');
            $table->string('placement');
            $table->string('style');
            $table->string('manufacturer');
            $table->string('size');
            $table->string('model');
            $table->string('serial');
            $table->integer('backflow_assembly_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backflow_old');
    }
}
