<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->integer('phone_number_type_id');
            $table->string('phone_number');
            $table->integer('creator_id');
            $table->integer('updater_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->foreign('creator_id')
                ->references('id')->on('contacts')
                ->onDelete('RESTRICT');
            $table->foreign('updater_id')
                ->references('id')->on('contacts')
                ->onDelete('RESTRICT');
            $table->foreign('phone_number_type_id')
                ->references('id')->on('phone_number_types')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_numbers');
    }
}
