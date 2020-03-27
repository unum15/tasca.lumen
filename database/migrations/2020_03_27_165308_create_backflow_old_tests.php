<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowOldTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_old_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('test_date');
            $table->string('check_1')->nullable();
            $table->string('check_2')->nullable();
            $table->string('rp_check_1')->nullable();
            $table->string('rp_check_2')->nullable();
            $table->string('rp')->nullable();
            $table->string('ail')->nullable();
            $table->string('ch_1')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backflow_old_tests');
    }
}
