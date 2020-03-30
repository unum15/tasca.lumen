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
            $table->string('active')->nullable();
            $table->string('prt')->nullable();
            $table->string('month')->nullable();
            $table->string('reference')->nullable();
            $table->string('group')->nullable();
            $table->string('water_system')->nullable();
            $table->string('account')->nullable();
            $table->string('owner');
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('location')->nullable();
            $table->string('laddress')->nullable();
            $table->string('lcity')->nullable();
            $table->string('lstate')->nullable();
            $table->string('lzip')->nullable();
            $table->string('gps')->nullable();
            $table->string('use')->nullable();
            $table->string('placement')->nullable();
            $table->string('style')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('size')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->string('notes')->nullable();
            $table->string('tag_year_end')->nullable();
            $table->string('installation')->nullable();
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
