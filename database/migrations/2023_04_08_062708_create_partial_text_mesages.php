<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartialTextMesages extends Migration
{
    public function up()
    {
        Schema::create('partial_text_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->integer('sort_order')->nullable();
            $table->integer('partial_text_message_type_id');
            $table->timestamps();
            $table->foreign('partial_text_message_type_id')
                ->references('id')
                ->on('partial_text_message_types')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('partial_text_messages');
    }
}
