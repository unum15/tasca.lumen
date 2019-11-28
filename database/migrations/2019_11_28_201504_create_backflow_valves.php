<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowValves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_valves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('test_label');
            $table->string('test_value');
            $table->string('success_label');
            $table->string('fail_label');
            $table->boolean('store_value');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backflow_valves');
    }
}
