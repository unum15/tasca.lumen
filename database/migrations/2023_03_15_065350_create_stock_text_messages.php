<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTextMessages extends Migration
{
    public function up()
    {
        Schema::create('stock_text_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_text_messages');
    }
}
