<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneNumberTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_number_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            /*
             *I agonized for weeks over how to handle setting defaults for drop down boxes.
             *Creating a column on the table didn't feel right to me.
             *It violates normalization.
             *After talking to four other people I decided it was better this way than a settings table.
             *Feel free to contact me and try to convince me to do it differently
             */
            $table->boolean('default')->default('false');
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
        Schema::dropIfExists('phone_number_types');
    }
}
