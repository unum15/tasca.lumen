<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameTableToStockMessages extends Migration
{
    public function up()
    {
        Schema::table('stock_text_messages', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('stock_text_messages', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
