<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartialTextMesageTypes extends Migration
{
    public function up()
    {
        Schema::create('partial_text_message_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partial_text_message_types');
    }
}
