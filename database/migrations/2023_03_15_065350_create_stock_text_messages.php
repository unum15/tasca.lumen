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
            $table->integer('message_type_id');
            $table->timestamps();
            $table->foreign('message_type_id')
                ->references('id')
                ->on('message_types')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_text_messages');
        $db->delete("DELETE FROM settings WHERE name='default_stock_text_message'");
    }
}
